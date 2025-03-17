{{-- confetti/index.blade.php --}}
@props([
    'uuid' => 'lara-ui-confetti-' . Str::random(8),
    'particleCount' => 100,
    'spread' => 70,
    'origin' => ['y' => 0.6],
])

@checkPluginInstalled('Confetti')

<div x-data="{
        runConfetti($event) {
            if ($event.detail.uuid === '{{ $uuid }}') {
                window.confetti({
                    particleCount: {{ $particleCount }},
                    spread: {{ $spread }},
                    origin: {{ json_encode($origin) }}
                });
            }
        }
    }"
     x-on:confetti.window="runConfetti"
    {{ $attributes }}
></div>
