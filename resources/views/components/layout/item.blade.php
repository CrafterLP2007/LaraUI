@props([
    'size' => '33.33',
    'minSize' => '0.0'
])

<div x-data="{
    checkSize() {
        if ({{ $minSize }} > {{ $size }}) {
            console.error('Layout Splitter Error:', {
                message: 'Minimum size cannot be less than the size',
                element: $el,
                size: {{ $size }},
                minSize: {{ $minSize }}
            });
        }
    }
}" x-init="checkSize()" class="overflow-hidden h-full" wire:ignore
     data-hs-layout-splitter-item='{
         "dynamicSize": {{ $size }},
         "minSize": {{ $minSize }}
     }'
     style="flex: {{ $size }} 1 0px;">
    <div {{ $attributes->twMerge('flex items-center justify-center h-full p-3 text-gray-800 dark:text-neutral-200') }}>
        {{ $slot }}
    </div>
</div>
