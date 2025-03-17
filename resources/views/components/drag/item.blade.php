@props([
    'uuid' => 'lara-ui-drag-item-' . Str::random(8),
])

<li
    data-uuid="{{ $uuid }}"
    x-bind:class="{
        'inline-flex items-center gap-x-3 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:mt-0 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 hover:bg-gray-50 dark:hover:bg-neutral-800 transition-all duration-200': true,
        'first:rounded-t-lg last:rounded-b-lg': !dragTarget || dragTarget !== $el
    }"
    draggable="false"
>
    {{ $slot }}

    <svg
        class="shrink-0 size-4 ms-auto text-gray-400 dark:text-neutral-500 cursor-grab drag-handle"
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
        <circle cx="9" cy="12" r="1"></circle>
        <circle cx="9" cy="5" r="1"></circle>
        <circle cx="9" cy="19" r="1"></circle>
        <circle cx="15" cy="12" r="1"></circle>
        <circle cx="15" cy="5" r="1"></circle>
        <circle cx="15" cy="19" r="1"></circle>
    </svg>
</li>
