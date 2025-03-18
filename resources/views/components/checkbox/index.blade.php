@props([
    'label' => null,
    'hint' => null,
    'showValidation' => true,
])

<div class="flex" x-data="{ uuid: Math.random().toString(20).substring(2, 20) }">
    <input
        type="checkbox"
        x-bind:id="uuid"
        {{ $attributes->merge([
            'class' => 'shrink-0 mt-0.5 border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800'
        ]) }}
    >

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <label x-bind:for="uuid" class="text-sm ms-3 text-red-500">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</label>
    @endif

    @if($label && !$attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()))
        <label x-bind:for="uuid" class="text-sm text-gray-500 ms-3 dark:text-neutral-500">{{ $label }}</label>
    @endif
</div>

@if($hint)
    <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">{{ $hint }}</p>
@endif
