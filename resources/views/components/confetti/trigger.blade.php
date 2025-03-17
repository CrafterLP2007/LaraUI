@props([
    'target' => null
])

<div x-data
     @click="$dispatch('confetti', { uuid: '{{ $target }}' })"
    {{ $attributes }}>
    {{ $slot }}
</div>
