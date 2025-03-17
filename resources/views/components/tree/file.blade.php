@props([
    'item' => [],
])

<div class="hs-tree-view-selected:bg-gray-100 dark:hs-tree-view-selected:bg-neutral-700 px-2 rounded-md cursor-pointer"
     role="treeitem"
     data-hs-tree-view-item='@json([
        "value" => $item['value'] ?? '',
        "isDir" => false
    ])'>
    <div class="flex items-center gap-x-3">
        <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
        </svg>
        <div class="grow">
            <span class="text-sm text-gray-800 dark:text-neutral-200">
                {{ $item['label'] ?? $item['value'] ?? '' }}
            </span>
        </div>
    </div>
</div>
