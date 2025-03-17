@props([
    'uuid' => 'lara-ui-combobox-' . Str::random(8),
    'label' => null,
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'hint' => null,
    'cornerHint' => null,
])

<div
    x-data="{
        open: false,
        selectedValue: null,
        searchTerm: '',
        options: {{ json_encode($options) }},

        init() {
            // Initialize from Livewire model if available
            const modelName = '{{ $attributes->whereStartsWith('wire:model')->first() }}';
            if (modelName) {
                $nextTick(() => {
                    let value = $wire.get(modelName.replace('wire:model', '').replace('.live', '').replace('.defer', '').trim());
                    if (value) {
                        this.selectedValue = value;
                        this.updateSelectedText();
                    }
                });

                if (window.Livewire) {
                    $wire.$watch(modelName.replace('wire:model', '').replace('.live', '').replace('.defer', '').trim(), value => {
                        this.selectedValue = value;
                        this.updateSelectedText();
                    });
                }
            }
        },

        select(value, text) {
            this.selectedValue = value;
            this.searchTerm = text;
            this.open = false;

            const modelName = '{{ $attributes->whereStartsWith('wire:model')->first() }}';
            if (modelName && window.Livewire) {
                $wire.set(modelName.replace('wire:model', '').replace('.live', '').replace('.defer', '').trim(), value);
            }
        },

        updateSelectedText() {
            if (!this.selectedValue) return;

            const option = this.options.find(opt => opt['{{ $optionValue }}'] == this.selectedValue);
            if (option) {
                this.searchTerm = option['{{ $optionLabel }}'];
            }
        },

        get filteredOptions() {
            return this.options.filter(option => {
                const label = option['{{ $optionLabel }}'] || '';
                return label.toString().toLowerCase().includes(this.searchTerm.toLowerCase());
            });
        }
    }"
    class="relative w-full"
    id="{{ $uuid }}"
>
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <label for="{{ $uuid }}-input" class="block text-sm font-medium dark:text-white">
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
        <input
            x-ref="trigger"
            id="{{ $uuid }}-input"
            type="text"
            x-model="searchTerm"
            @input="open = true"
            placeholder="{{ __('lara-ui::combobox.placeholder') }}"
            class="py-2.5 sm:py-3 ps-4 pe-9 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
            {{ $attributes->except(['wire:model', 'wire:model.live', 'wire:model.defer']) }}
        >
        <div
            class="absolute top-1/2 end-3 -translate-y-1/2 cursor-pointer"
            @click="open = !open"
        >
            <svg class="shrink-0 size-3.5 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg"
                 width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="m7 15 5 5 5-5"></path>
                <path d="m7 9 5-5 5 5"></path>
            </svg>
        </div>

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
            <template x-for="(option, index) in filteredOptions" :key="index">
                <div
                    @click="select(option['{{ $optionValue }}'], option['{{ $optionLabel }}'])"
                    class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800"
                    :class="{ 'bg-gray-100 dark:bg-neutral-800': selectedValue == option['{{ $optionValue }}'] }"
                    :data-value="option['{{ $optionValue }}']"
                >
                    <div class="flex justify-between items-center w-full">
                        <span x-text="option['{{ $optionLabel }}']"></span>
                        <template x-if="selectedValue == option['{{ $optionValue }}']">
                            <svg class="shrink-0 size-3.5 text-blue-600 dark:text-blue-500"
                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                        </template>
                    </div>
                </div>
            </template>

            <div x-show="filteredOptions.length === 0"
                 class="py-2 px-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                {{ __('lara-ui::combobox.no_options_found') }}
            </div>
        </div>
    </div>

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()))
        <div
            class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>
