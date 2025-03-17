@props([
    'content' => null,
    'position' => 'top',
    'trigger' => 'click',
])

@php
    $positionClass = match($position) {
        'left' => '[--placement:left]',
        'right' => '[--placement:right]',
        'bottom' => '[--placement:bottom]',
        default => ''
    };

    $triggerClass = match($trigger) {
        'hover' => '',
        default => '[--trigger:click]'
    };
@endphp

<div
    class="hs-tooltip {{ $positionClass }} {{ $triggerClass }} inline-block"
    {{ $attributes }}
>
    <div class="hs-tooltip-toggle">
        {{ $slot }}
        <span {{ $attributes->twMerge('hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-3 px-4 bg-white border border-gray-200 text-sm text-gray-600 rounded-lg shadow-md dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400') }} role="tooltip">
            {{ $content ?? '' }}
        </span>
    </div>
</div>
