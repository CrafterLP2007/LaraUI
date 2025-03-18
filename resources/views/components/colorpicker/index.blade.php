@props([
    'label' => null,
    'hint' => null,
    'showValidation' => true,
])

<div x-data="{ uuid: Math.random().toString(20).substring(2, 20) }">
    <div class="relative">
        @if($label)
            <label x-bind:for="uuid" class="block text-sm font-medium dark:text-white mb-2">
                {{ $label }}
            </label>
        @endif
    </div>

    <input x-bind:id="uuid" type="color" {{ $attributes->twMerge('p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700" id="hs-color-input') }} {{ $attributes }}>

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div
            class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif

</div>
