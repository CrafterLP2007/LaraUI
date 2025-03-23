@props([
    'label' => null,
    'cornerHint' => null,
    'hint' => null,
    'step' => 1,
    'min' => null,
    'max' => null,
])

<div class="relative" x-data="{ uuid: Math.random().toString(20).substring(2, 20) }">
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <label x-bind:for="uuid" class="block text-sm font-medium dark:text-white">
                {{ $label }}
            </label>
            @if($cornerHint)
                <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $cornerHint }}</span>
            @endif
        </div>
    @endif

    <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg dark:bg-neutral-900 dark:border-neutral-700">
        <div class="w-full flex justify-between items-center gap-x-3"
             x-data="{
            value: {{ $attributes->get('value') ?? 0 }},
            step: {{ $step ?? 1 }},
            min: {{ $min ?? 'null' }},
            max: {{ $max ?? 'null' }},
            increment() {
                let newValue = parseFloat(this.value) + this.step;
                if (this.max === null || newValue <= this.max) {
                    this.value = newValue;
                }
            },
            decrement() {
                let newValue = parseFloat(this.value) - this.step;
                if (this.min === null || newValue >= this.min) {
                    this.value = newValue;
                }
            }
         }"
             wire:ignore>
            <input
                {{ $attributes->twMerge('w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none dark:text-white') }}
                style="-moz-appearance: textfield;"
                type="number"
                x-model.number="value"
                :min="min"
                :max="max"
                :step="step"
                {{ $attributes }}
            >
            <div class="flex justify-end items-center gap-x-1.5">
                <button type="button"
                        class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        x-on:click="decrement">
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                    </svg>
                </button>
                <button type="button"
                        class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        x-on:click="increment">
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div
            class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>
