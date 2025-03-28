@props([
    'selectedTab' => null,
])

<div x-data="{ selectedTab: '{{ $selectedTab }}' ? '{{ $selectedTab }}' : @entangle($attributes->wire('model')) }"
    {{ $attributes->twMerge('border-b border-gray-200 dark:border-neutral-700') }}>
    <nav {{ $attributes->twMerge('flex gap-x-1') }} role="tablist" aria-orientation="horizontal" aria-label="tab options" @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()">
        {{ $slot }}
    </nav>
</div>
