@props([
    'closeWhenClickAway' => false,
])

<div
    x-data="{
        isOpen: false,
        closeWhenClickAway: {{ $closeWhenClickAway ? 'true' : 'false' }}
     }"
    {{ $attributes->twMerge('hs-dropdown relative inline-flex') }}
    @click.away="closeWhenClickAway ? isOpen = false : null"
>
    {{ $slot }}
</div>
