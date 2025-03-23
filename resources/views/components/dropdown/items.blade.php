@props([
    'position' => 'bottom'
])

<div x-show="isOpen"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="transform opacity-0 -translate-y-2"
     x-transition:enter-end="transform opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-75"
     x-transition:leave-start="transform opacity-100 translate-y-0"
     x-transition:leave-end="transform opacity-0 -translate-y-2"
     @class([
         'absolute z-90 min-w-60 bg-white shadow-md rounded-lg dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700',
         'top-full mt-2' => $position === 'bottom',
         'bottom-full mb-2' => $position === 'top',
         'left-0' => $position === 'bottom-left' || $position === 'left',
         'right-0' => $position === 'bottom-right' || $position === 'right',
     ])
     role="menu"
     aria-orientation="vertical"
     style="display: none;">
    <div class="p-1 space-y-0.5">
        {{ $slot }}
    </div>
</div>
