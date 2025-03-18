<span {{ $attributes->twMerge('mt-1.5 flex items-center gap-x-1 text-xs text-gray-500 dark:text-neutral-500') }}>
    {{ $slot }}

    <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6 7 17l-5-5"></path>
        <path d="m22 10-7.5 7.5L13 16"></path>
    </svg>
</span>
