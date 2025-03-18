@props([
    'label' => null,
    'hint' => null,
    'value' => null,
])

<div class="flex">
    <input
        type="radio"
        x-bind:id="uuid + '-{{ $value }}'"
        x-bind:name="uuid"
        x-model="selected"
        value="{{ $value }}"
        {{ $attributes->twMerge('shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800') }}
    >

    <label x-bind:for="uuid + '-{{ $value }}'" class="ms-3">
        @if($label)
            <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-300">{{ $label }}</span>
        @endif
        @if($hint)
            <span class="block text-sm text-gray-600 dark:text-neutral-500">{{ $hint }}</span>
        @endif
    </label>
</div>
