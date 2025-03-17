@props([
    'uuid' => 'lara-ui-carousel-slide-' . Str::random(8),
    'background' => 'bg-gray-100 dark:bg-neutral-900'
])

<div class="hs-carousel-slide">
    <div class="flex justify-center h-full {{ $background }} p-6">
        {{ $slot }}
    </div>
</div>
