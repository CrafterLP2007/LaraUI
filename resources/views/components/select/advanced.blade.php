@php use Illuminate\Support\Collection; @endphp
@props([
    'uuid' => 'lara-ui-advanced-select-' . \Illuminate\Support\Str::random(8),
    'variant' => 'default',
    'label' => null,
    'hint' => null,
    'cornerHint' => null,
    'showValidation' => true,
    'placeholder' => null,

    'search' => false,
    'searchPlaceholder' => 'Search...',

    'options' => [],
    'optionLabel' => 'name',
    'optionValue' => 'id'
])

<div>
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <label for="{{ $uuid }}" class="block text-sm font-medium dark:text-white">
                {{ $label }}
            </label>
            @if($cornerHint)
                <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $cornerHint }}</span>
            @endif
        </div>
    @endif

    <!-- Select -->
    <div
        x-data="{
            open: false,
            value: null,
            text: '',
            init() {
                // Get Preline Select instance
                const select = HSSelect.getInstance(this.$refs.select);

                // Check if we're in a Livewire context
                const hasWireModel = {{ $attributes->whereStartsWith('wire:model')->isNotEmpty() ? 'true' : 'false' }};

                if (hasWireModel) {
                    // Get initial value from Livewire
                    const modelName = '{{ $attributes->wire('model')->value() }}';

                    try {
                        const initialValue = $wire.get(modelName);

                        if (initialValue !== undefined && initialValue !== null) {
                            this.value = initialValue;
                            select.selectOption(String(initialValue));
                        }

                        // Setup change listener for HSSelect
                        select.on('change', (value) => {
                            const numValue = !isNaN(value) && value !== '' ? Number(value) : value;
                            $wire.set(modelName, numValue);
                            this.value = numValue;
                        });

                        // Watch for Livewire updates
                        $wire.$watch(modelName, (newValue) => {
                            if (newValue !== this.value) {
                                this.value = newValue;
                                if (newValue !== null && newValue !== undefined && newValue !== '') {
                                    select.selectOption(String(newValue));
                                } else {
                                    select.deselectAllOptions();
                                }
                            }
                        });
                    } catch (e) {
                        // Fallback for non-Livewire contexts
                        select.on('change', (value) => {
                            this.value = !isNaN(value) && value !== '' ? Number(value) : value;
                        });
                    }
                } else {
                    // Regular behavior for non-Livewire
                    select.on('change', (value) => {
                        this.value = !isNaN(value) && value !== '' ? Number(value) : value;
                    });
                }
            }
        }"
    >
        <select
            id="{{ $uuid }}"
            x-ref="select"
            {{ $attributes->whereDoesntStartWith('wire:model') }}
            data-hs-select='{
                "placeholder": "{{ $placeholder }}",
                "hasSearch": {{ $search ? 'true' : 'false' }},
                "searchPlaceholder": "{{ $searchPlaceholder }}",
                "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-1.5 sm:py-2 px-3",
                "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
            }'
            class="hidden"
        >
            @php
                // Handle different option types (array, Collection, etc.)
                $normalizedOptions = $options;
                if ($options instanceof Collection) {
                    $normalizedOptions = $options->all();
                } elseif (!is_array($options)) {
                    $normalizedOptions = [];
                }
            @endphp

            @foreach($normalizedOptions as $option)
                @php
                    $optValue = is_array($option) ? ($option[$optionValue] ?? '') : (is_object($option) ? ($option->{$optionValue} ?? '') : $option);
                    $optLabel = is_array($option) ? ($option[$optionLabel] ?? $optValue) : (is_object($option) ? ($option->{$optionLabel} ?? $optValue) : $option);
                    $disabled = is_array($option) ? ($option['disabled'] ?? false) : (is_object($option) ? ($option->disabled ?? false) : false);
                @endphp
                <option value="{{ $optValue }}" {{ $disabled ? 'disabled' : '' }}>{{ $optLabel }}</option>
            @endforeach
        </select>
    </div>
    <!-- End Select -->

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>
