@props(['item'])

<div class="{{ $item['isDir'] ? 'hs-accordion' : '' }} {{ isset($item['isDir']) && $item['isDir'] && (isset($item['collapsed']) && !$item['collapsed']) ? 'active' : '' }}"
     role="treeitem"
     id="hs-cco-tree-heading-{{ $item['value'] }}"
     data-hs-tree-view-item='@json($item)'>
    <div class="py-0.5 rounded-md flex items-center gap-x-0.5 w-full hs-tree-view-selected:bg-gray-100 dark:hs-tree-view-selected:bg-neutral-700">
        @if($item['isDir'])
            <button type="button"
                    class="hs-accordion-toggle size-6 flex justify-center items-center hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                    aria-controls="hs-cco-tree-collapse-{{ $item['value'] }}"
                    aria-expanded="{{ isset($item['collapsed']) && !$item['collapsed'] }}">
                <svg class="size-4 text-gray-800 dark:text-neutral-200 block"
                     xmlns="http://www.w3.org/2000/svg"
                     width="24"
                     height="24"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.5"
                     stroke-linecap="round"
                     stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <line class="hs-accordion-active:hidden" x1="12" y1="5" x2="12" y2="19"></line>
                </svg>
            </button>
        @else
            <div class="size-6"></div>
        @endif

        <div class="grow px-1.5 rounded-md cursor-pointer" data-hs-tree-view-select>
            <div class="flex items-center gap-x-3">
                @if($item['isDir'])
                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                         xmlns="http://www.w3.org/2000/svg"
                         width="24"
                         height="24"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.5"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                    </svg>
                @else
                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                         xmlns="http://www.w3.org/2000/svg"
                         width="24"
                         height="24"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.5"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                @endif
                <span class="text-sm text-gray-800 dark:text-neutral-200">
                    {{ $item['value'] }}
                </span>
            </div>
        </div>
    </div>

    @if ($item['isDir'])
        <div id="hs-cco-tree-collapse-{{ $item['value'] }}"
             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ isset($item['collapsed']) && !$item['collapsed'] ? 'block' : 'hidden' }}"
             aria-labelledby="hs-cco-tree-heading-{{ $item['value'] }}">
            <div class="ps-7 relative before:absolute before:top-0 before:start-3 before:w-0.5 before:-ms-px before:h-full before:bg-gray-100 dark:before:bg-neutral-700">
                @foreach ($item['children'] as $child)
                    <x-lara-ui::tree.item :item="$child" />
                @endforeach
            </div>
        </div>
    @endif
</div>
