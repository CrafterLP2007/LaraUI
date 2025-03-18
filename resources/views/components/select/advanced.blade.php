@props([
    'label' => null,
    'cornerHint' => null,
    'hint' => null,
    'showValidation' => true,
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'multiple' => false,
])

<div x-data="{
    uuid: Math.random().toString(20).substring(2, 20),
    open: false,
    selectedValues: [],
    options: {{ json_encode($options) }},

    init() {
        const modelName = '{{ $attributes->whereStartsWith('wire:model')->first() }}';
        if (modelName) {
            $nextTick(() => {
                let value = $wire.get(modelName.replace('wire:model', '').replace('.live', '').replace('.defer', '').trim());
                if (value) {
                    this.selectedValues = {{ $multiple ? 'true' : 'false' }} ? (Array.isArray(value) ? value : []) : (Array.isArray(value) ? [value[0]] : [value]);
                }
            });

            if (window.Livewire) {
                $wire.$watch(modelName.replace('wire:model', '').replace('.live', '').replace('.defer', '').trim(), value => {
                    if (value) {
                        this.selectedValues = {{ $multiple ? 'true' : 'false' }} ? (Array.isArray(value) ? value : []) : (Array.isArray(value) ? [value[0]] : [value]);
                    } else {
                        this.selectedValues = [];
                    }
                });
            }
        }
    },

    select(value) {
        if ({{ $multiple ? 'true' : 'false' }}) {
            const index = this.selectedValues.indexOf(value);
            if (index === -1) {
                this.selectedValues.push(value);
            } else {
                this.selectedValues.splice(index, 1);
            }
        } else {
            this.selectedValues = [value];
            this.open = false;
        }

        const modelName = '{{ $attributes->whereStartsWith('wire:model')->first() }}';
        if (modelName && window.Livewire) {
            const finalValue = {{ $multiple ? 'true' : 'false' }} ? this.selectedValues : this.selectedValues[0] || null;
            $wire.set(modelName.replace('wire:model', '').replace('.live', '').replace('.defer', '').trim(), finalValue);
        }
    },

    getSelectedLabels() {
        return this.selectedValues
            .map(value => this.options.find(opt => opt['{{ $optionValue }}'] == value)?.['{{ $optionLabel }}'])
            .filter(label => label)
            .join(', ') || '{{ __('Choose') }}';
    }
}">
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <label x-bind:for="uuid" class="block text-sm font-medium dark:text-white">
                {{ $label }}
                @if($attributes->has('required'))
                    <span class="text-red-500">*</span>
                @endif
            </label>
            @if($cornerHint)
                <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $cornerHint }}</span>
            @endif
        </div>
    @endif

    <div class="relative">
        <button
            type="button"
            @click="open = !open"
            class="relative w-full py-2.5 px-4 text-left text-sm text-gray-800 bg-white border border-gray-200 rounded-lg cursor-pointer focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300"
            {{ $attributes->except(['wire:model', 'wire:model.live', 'wire:model.defer']) }}
        >
            <span x-text="getSelectedLabels()"></span>
            <span class="absolute end-3 top-1/2 -translate-y-1/2">
                <svg class="size-3.5 text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m7 15 5 5 5-5"></path>
                    <path d="m7 9 5-5 5 5"></path>
                </svg>
            </span>
        </button>

        <div
            x-show="open"
            @click.outside="open = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-1 w-full max-h-72 p-1 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700"
            style="display: none;"
        >
            <template x-for="(option, index) in options" :key="index">
                <div
                    @click="select(option['{{ $optionValue }}'])"
                    class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800"
                    :class="{ 'bg-gray-100 dark:bg-neutral-800': selectedValues.includes(option['{{ $optionValue }}']) }"
                >
                    <div class="flex justify-between items-center w-full">
                        <span x-text="option['{{ $optionLabel }}']"></span>
                        <template x-if="selectedValues.includes(option['{{ $optionValue }}'])">
                            <svg class="shrink-0 size-3.5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()))
        <div class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>
