<button
    type="button"
    {{ $attributes->twMerge('w-full flex items-center gap-x-3 py-1.5 px-3 rounded-lg text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700') }}
    role="menuitem"
>
    {{ $slot }}
</button>
