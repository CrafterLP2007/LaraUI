@props([
    'text' => '',
    'timeout' => 3000,
])

<button
    type="button"
    x-data="{
        showSuccess: false,
        timeout: {{ $timeout }},
        async copyToClipboard() {
            await navigator.clipboard.writeText(@js($text));
            this.showSuccess = true;
            setTimeout(() => {
                this.showSuccess = false;
            }, this.timeout);
        }
    }"
    @click="copyToClipboard"
    {{ $attributes->twMerge('p-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 cursor-pointer') }}
>
    <svg
        x-cloak
        x-show="!showSuccess"
        class="size-4 group-hover:rotate-6 transition"
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
    </svg>

    <svg
        x-cloak
        x-show="showSuccess"
        class="size-4 text-blue-600"
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
</button>
