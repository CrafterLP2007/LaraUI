@props([
    'openOnHover' => false,
])

<div
    x-data="{
        openOnHover: {{ json_encode($openOnHover) }}
    }"
    @click="isOpen = !isOpen"
    @mouseenter="openOnHover ? isOpen = true : null"
    :aria-expanded="isOpen"
    {{ $attributes->twMerge('') }}
>
    {{ $slot }}
</div>
