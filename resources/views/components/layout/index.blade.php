@props([
    'direction' => 'horizontal',
    'height' => 'h-50',
    'horizontalSplitterClasses' => 'relative flex border-s border-gray-200 dark:border-neutral-700',
    'verticalSplitterClasses' => 'relative flex border-t border-gray-200 dark:border-neutral-700'
])

@php
    $horizontalSplitterTemplate = '<div><span class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 block w-4 h-6 flex justify-center items-center bg-white border border-gray-200 text-gray-400 rounded-md cursor-col-resize hover:bg-gray-100 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-600 dark:hover:bg-neutral-900"><svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="12" r="1"/><circle cx="9" cy="5" r="1"/><circle cx="9" cy="19" r="1"/><circle cx="15" cy="12" r="1"/><circle cx="15" cy="5" r="1"/><circle cx="15" cy="19" r="1"/></svg></span></div>';
    $verticalSplitterTemplate = '<div><span class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 block w-6 h-4 flex justify-center items-center bg-white border border-gray-200 text-gray-400 rounded-md cursor-row-resize hover:bg-gray-100 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-600 dark:hover:bg-neutral-900"><svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="1"/><circle cx="19" cy="9" r="1"/><circle cx="5" cy="9" r="1"/><circle cx="12" cy="15" r="1"/><circle cx="19" cy="15" r="1"/><circle cx="5" cy="15" r="1"/></svg></span></div>';
    $id = 'splitter-' . uniqid();
@endphp

<div id="{{ $id }}" data-hs-layout-splitter='{
    "{{ $direction }}SplitterTemplate": @json($direction === 'horizontal' ? $horizontalSplitterTemplate : $verticalSplitterTemplate),
    "{{ $direction }}SplitterClasses": "{{ $direction === 'horizontal' ? $horizontalSplitterClasses : $verticalSplitterClasses }}"
}'>
    <div class="flex {{ $direction === 'vertical' ? 'flex-col' : '' }} border border-gray-200 rounded-lg {{ $height }} dark:border-neutral-700"
         data-hs-layout-splitter-{{ $direction }}-group="">
        {{ $slot }}
    </div>
</div>
