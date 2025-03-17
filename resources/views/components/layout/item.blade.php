@props([
    'size' => '33.33'
])

<div class="overflow-hidden h-full"
     data-hs-layout-splitter-item="{{ $size }}"
     style="flex: {{ $size }} 1 0px;">
    <div class="flex items-center justify-center h-full p-3 text-gray-800 dark:text-neutral-200">
        {{ $slot }}
    </div>
</div>
