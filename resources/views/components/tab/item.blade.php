@props([
    'uuid' => 'lara-ui-tab-item-' . uniqid(),
    'link' => null,
])

@if($link)
    <a
        @click="selectedTab = '{{ $uuid }}'"
        :aria-selected="selectedTab === '{{ $uuid }}'"
        :tabindex="selectedTab === '{{ $uuid }}' ? '0' : '-1'"
        :class="selectedTab === '{{ $uuid }}' ? 'active font-semibold border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-neutral-400'"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 text-sm whitespace-nowrap hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:hover:text-blue-500"
        href="{{ $link }}"
        role="tab">
        {{ $slot }}
    </a>
@else
    <button
        type="button"
        @click="selectedTab = '{{ $uuid }}'"
        :aria-selected="selectedTab === '{{ $uuid }}'"
        :tabindex="selectedTab === '{{ $uuid }}' ? '0' : '-1'"
        :class="selectedTab === '{{ $uuid }}' ? 'active font-semibold border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-neutral-400'"
        class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 text-sm whitespace-nowrap hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:hover:text-blue-500 cursor-pointer"
        role="tab">
        {{ $slot }}
    </button>
@endif
