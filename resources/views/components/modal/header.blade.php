<!-- header.blade.php -->
@props([
    'close' => null,
    'title' => null
])

<div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
    <h3 class="font-bold text-gray-800 dark:text-white">
        {{ $title }}
    </h3>
    {{ $close }}
</div>
