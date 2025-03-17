@props(['title'])

<div
    x-cloak
    :id="id"
    x-show="open"
    x-transition:enter="transition-all duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition-all duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    role="dialog"
    tabindex="-1"
    :aria-labelledby="`${id}-label`"
    {{ $attributes->merge(['class' => 'fixed top-0 start-0 h-full max-w-xs w-full z-80 bg-white border-e border-gray-200 dark:bg-neutral-800 dark:border-neutral-700']) }}
>
    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
        <h3 :id="`${id}-label`" class="font-bold text-gray-800 dark:text-white">{{ $title }}</h3>
        <button
            type="button"
            x-on:click="close"
            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
        >
            <span class="sr-only">Close</span>
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
    </div>
    <div class="p-4">
        {{ $slot }}
    </div>
</div>
