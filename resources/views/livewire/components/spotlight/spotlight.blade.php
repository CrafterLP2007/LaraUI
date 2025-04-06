<div
    x-data="{
        open: @entangle('open'),
        selectedIndex: 0,
        items: [],
        init() {
            this.toggleOverflow();
            this.$watch('open', value => {
                this.toggleOverflow();
                if (value) {
                    this.$nextTick(() => this.$refs.searchInput.focus());
                    this.selectedIndex = -1;
                }
            });
            this.$watch('$wire.searchTerm', () => this.selectedIndex = -1);
        },
        toggleOverflow() {
            document.body.style.overflow = this.open ? 'hidden' : 'auto';
        },
        get visibleItems() {
            return Array.from(this.$el.querySelectorAll('[data-spotlight-item]'));
        },
        selectNext() {
            if (this.visibleItems.length === 0) return;
            this.selectedIndex = (this.selectedIndex + 1) % this.visibleItems.length;
            this.scrollToSelected();
        },
        selectPrev() {
            if (this.visibleItems.length === 0) return;
            this.selectedIndex = (this.selectedIndex - 1 + this.visibleItems.length) % this.visibleItems.length;
            this.scrollToSelected();
        },
        scrollToSelected() {
            const selected = this.visibleItems[this.selectedIndex];
            if (selected) {
                selected.scrollIntoView({ block: 'nearest' });
            }
        },
        selectCurrent() {
            if (this.selectedIndex === -1) return;
            const selected = this.visibleItems[this.selectedIndex];
            if (!selected) return;

            const button = selected;
            if (!button) return;

            button.click();
            this.open = false;
        }
    }"
    x-show="open"
    @keydown.escape.window="open = false"
    @keydown.arrow-down.prevent="selectNext"
    @keydown.arrow-up.prevent="selectPrev"
    @keydown.enter.prevent="selectCurrent"
    @click="open = false"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 overflow-y-auto"
    style="z-index: 99999;"
    x-cloak
>

    <div
        class="fixed inset-0 bg-gray-500/70 dark:bg-neutral-800/70 backdrop-blur-lg"
        @click="open = false"
    ></div>

    <div
        class="relative min-h-screen flex items-center justify-center p-4"
    >
        <div
            class="flex flex-col bg-neutral-100 dark:bg-neutral-800 rounded-xl min-h-[600px] w-full max-w-2xl border dark:border-neutral-700 border-neutral-200"
            @click.stop
        >
            <div class="w-full">
                <div class="relative w-full border-b border-gray-200 dark:border-neutral-700">
                    <input type="text"
                           x-ref="searchInput"
                           wire:model.live="searchTerm"
                           class="py-1.5 sm:py-3.5 px-3 ps-9 block w-full shadow-2xs rounded-t-xl sm:text-sm disabled:pointer-events-none bg-neutral-800 dark:text-neutral-400 dark:placeholder-neutral-500 border-none focus:ring-0"
                           placeholder="{{ __('lara-ui::spotlight.search') }}">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                        <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="w-full flex-1 overflow-y-auto max-h-[600px] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                <div class="p-4">
                    <p class="text-xs text-neutral-200 dark:text-neutral-500">{{ __('lara-ui::spotlight.categories') }}</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($this->getCategories() as $category)
                            <a class="p-2 rounded-full flex items-center gap-2 border border-neutral-200 dark:border-neutral-700 text-xs hover:bg-gray-100 dark:hover:bg-neutral-700"
                               href="#"
                               @click.prevent="$el.closest('.overflow-y-auto').querySelector('#category-{{ Str::slug($category) }}').scrollIntoView({ behavior: 'smooth' })">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="size-4 text-white">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                </svg>
                                <span class="text-gray-800 dark:text-neutral-200">{{ $category }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($history && $history->isNotEmpty() && !$searchTerm)
                    <div class="px-4 mb-4">
                        <div class="border-t border-gray-200 dark:border-neutral-700">
                            <div class="mt-4">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-neutral-200 dark:text-neutral-500">{{ __('lara-ui::spotlight.recent') }}</p>
                                    <button wire:click="clearHistory">
                                        <i class="icon-x text-red-600"></i>
                                    </button>
                                </div>
                                <ul class="mt-2">
                                    @foreach($history as $id)
                                        @php
                                            $item = $items->first(fn($i) => $i->getId() === $id);
                                        @endphp
                                        @if($item)
                                            <li class="rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                <button wire:click="select('{{ $item->getId() }}')"
                                                        class="flex items-center gap-3 py-2 px-3 text-sm text-gray-800 dark:text-neutral-200">
                                                    {!! $item->getIcon() !!}
                                                    <span>{{ $item->getLabel() }}</span>
                                                    @if($item->getSuffix())
                                                        <span class="text-neutral-600">{{ $item->getSuffix() }}</span>
                                                    @endif
                                                </button>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    @php
                        $hasResults = false;
                        foreach($this->getCategories() as $category) {
                            if($this->getFilteredItems($category)->isNotEmpty()) {
                                $hasResults = true;
                                break;
                            }
                        }
                    @endphp

                    @if(!$hasResults && $searchTerm)
                        <div class="px-4 py-8 text-center">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                {{ __('lara-ui::spotlight.no_results', ['search' => $searchTerm]) }}
                            </p>
                        </div>
                    @else
                        <div>
                            @php
                                $itemCounter = 0;
                            @endphp

                            @foreach($this->getCategories() as $category)
                                @php
                                    $categoryItems = $this->getFilteredItems($category);
                                @endphp
                                @if($categoryItems->isNotEmpty())
                                    <div id="category-{{ Str::slug($category) }}" class="px-4 @if(!$loop->first) mt-4 @endif">
                                        <div class="border-t border-gray-200 dark:border-neutral-700">
                                            <div class="mt-4">
                                                <p class="text-xs text-neutral-200 dark:text-neutral-500">{{ $category }}</p>
                                                <ul class="mt-2">
                                                    @foreach($categoryItems as $item)
                                                        <li class="rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                            <button wire:click="select('{{ $item->getId() }}')"
                                                                    data-spotlight-item
                                                                    :class="{ 'bg-gray-100 dark:bg-neutral-700 rounded-lg': selectedIndex === {{ $itemCounter }} }"
                                                                    @mouseover="selectedIndex = -1"
                                                                    class="flex items-center gap-3 py-2 px-3 text-sm text-gray-800 dark:text-neutral-200 w-full">
                                                                {!! $item->getIcon() !!}
                                                                <span>{{ $item->getLabel() }}</span>
                                                                @if($item->getSuffix())
                                                                    <span class="text-neutral-600">{{ $item->getSuffix() }}</span>
                                                                @endif
                                                            </button>
                                                        </li>
                                                        @php $itemCounter++; @endphp
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="w-full p-3 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex items-center lg:flex-row flex-col justify-between px-2">
                    <div class="flex items-center gap-2">
                        <kbd
                            class="h-6 w-auto px-1 inline-flex justify-center items-center border border-gray-200 dark:border-neutral-700 bg-transparent font-mono text-xs text-gray-800 rounded dark:text-neutral-200">esc</kbd>
                        <span class="text-xs text-neutral-200 dark:text-neutral-500">{{ __('lara-ui::spotlight.kbd_esc') }}</span>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <kbd
                                class="h-6 w-auto px-1 inline-flex justify-center items-center border border-gray-200 dark:border-neutral-700 bg-transparent font-mono text-xs text-gray-800 rounded dark:text-neutral-200">↵</kbd>
                            <span class="text-xs text-neutral-200 dark:text-neutral-500">{{ __('lara-ui::spotlight.kbd_select') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-2">
                                <kbd
                                    class="h-6 w-auto px-1 inline-flex justify-center items-center border border-gray-200 dark:border-neutral-700 bg-transparent font-mono text-xs text-gray-800 rounded dark:text-neutral-200">↑</kbd>
                                <kbd
                                    class="h-6 w-auto px-1 inline-flex justify-center items-center border border-gray-200 dark:border-neutral-700 bg-transparent font-mono text-xs text-gray-800 rounded dark:text-neutral-200">↓</kbd>
                            </div>
                            <span class="text-xs text-neutral-200 dark:text-neutral-500">{{ __('lara-ui::spotlight.kbd_navigate') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
