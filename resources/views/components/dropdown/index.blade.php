@props([
    'closeWhenClickAway' => false,
])

<div
    x-data="{
        isOpen: false,
        closeWhenClickAway: {{ $closeWhenClickAway }}
     }"
    {{ $attributes->twMerge('hs-dropdown relative inline-flex') }}
    @click.away="closeWhenClickAway ? isOpen = false : null"
>
    {{ $slot }}
</div>
