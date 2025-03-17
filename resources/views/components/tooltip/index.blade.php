@props([
    'uuid' => 'lara-ui-tooltip-' . \Illuminate\Support\Str::random(8),
    'tip' => null,
    'position' => 'top',
])

@php
    $positionClass = match($position) {
        'left' => '[--placement:left]',
        'right' => '[--placement:right]',
        'bottom' => '[--placement:bottom]',
        default => ''
    };
@endphp

<div
    id="{{ $uuid }}"
    class="hs-tooltip {{ $positionClass }} inline-block"
    {{ $attributes }}
>
    <div class="hs-tooltip-toggle">
        {{ $slot }}
        <span {{ $attributes->twMerge('hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700') }} role="tooltip">
            {{ $tip ?? '' }}
        </span>
    </div>
</div>
