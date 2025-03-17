@props([
    'uuid' => 'lara-ui-accordion-item' . str()->uuid(),
])

<div x-data="{ uuid: Math.random().toString(20).substring(2, 20) }" {{ $attributes->twMerge('') }}>
    {{ $slot }}
</div>
