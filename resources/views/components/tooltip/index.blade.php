@props([
    'tip' => null,
    'position' => 'top',
])

@php
    $positionClasses = match($position) {
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        default => 'bottom-full left-1/2 -translate-x-1/2 mb-2'
    };
@endphp

<div
    x-data="{ isVisible: false }"
    class="relative inline-block"
    {{ $attributes }}
    @mouseenter="isVisible = true"
    @mouseleave="isVisible = false"
>
    {{ $slot }}
    <span
        x-show="isVisible"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        {{ $attributes->twMerge('absolute ' . $positionClasses . ' z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700 whitespace-nowrap') }}
        role="tooltip"
        style="display: none;"
    >
        {{ $tip ?? '' }}
    </span>
</div>
