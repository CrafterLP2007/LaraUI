{{-- confetti/trigger.blade.php --}}
@props([
    'uuid' => 'lara-ui-confetti-trigger-' . Str::random(8),
    'target' => null
])

<div x-data
     @click="$dispatch('confetti', { uuid: '{{ $target }}' })"
    {{ $attributes }}>
    {{ $slot }}
</div>
