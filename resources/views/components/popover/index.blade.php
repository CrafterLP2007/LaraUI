@props([
    'content' => null,
    'position' => 'top',
    'trigger' => 'hover',
])

@php
    $positionClasses = match($position) {
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2'
    };
@endphp

<div
    x-data="{ isVisible: false }"
    class="relative inline-block"
    {{ $attributes }}
    @if($trigger === 'hover')
        @mouseenter="isVisible = true"
    @mouseleave="isVisible = false"
    @else
        @click.away="isVisible = false"
    @click="isVisible = !isVisible"
    @endif
>
    {{ $slot }}
    <div
        x-show="isVisible"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        {{ $attributes->twMerge('absolute min-w-max ' . $positionClasses . ' z-10 py-3 px-4 bg-white border border-gray-200 text-sm text-gray-600 rounded-lg shadow-md dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400') }}
        role="tooltip"
        style="display: none;"
    >
        {{ $content ?? '' }}
    </div>
</div>
