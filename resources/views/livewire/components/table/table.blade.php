<div class="dark:bg-neutral-800 bg-white/80 p-6 rounded-xl">
    <div class="mb-5">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            @if($options->searchable)
                <div class="flex items-center gap-4">
                    <div class="relative w-full md:w-72">
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="{{ __('lara-ui::datatable.search_placeholder') }}"
                        >
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                            <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.3-4.3"/>
                            </svg>
                        </div>
                    </div>

                    @if($options->loading)
                        <x-lara-ui::spinner wire:loading/>
                    @endif
                </div>
            @endif

            <div class="flex items-center md:flex-row flex-col gap-2">
                @if($options->bulkActions && count($selected) > 0 && count($bulkActions) > 0)
                    <div class="dropdown" x-data="{ open: false }" wire:transition>
                        <button
                            @click="open = !open"
                            class="dark:bg-neutral-900 py-2.5 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-blue-600"
                        >
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                            {!! __('lara-ui::datatable.bulk_actions', ['count' => count($selected)]) !!}
                        </button>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="absolute z-90 min-w-60 bg-white shadow-md rounded-lg dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 mt-2"
                            x-transition
                        >
                            <div class="p-3 border-b border-gray-200 dark:border-neutral-700">
                                <p class="text-sm text-gray-600 dark:text-neutral-400">
                                    {!! __('lara-ui::datatable.selected_items_text', ['selected' => count($selected), 'items' => $data->total()]) !!}
                                </p>
                            </div>

                            <div class="p-2">
                                @foreach($bulkActions as $action)
                                    <x-lara-ui::button variant="soft" color="secondary"
                                                       class="w-full py-2 flex justify-center items-center"
                                                       wire:click="executeBulkAction('{{ $action->getLabel() }}')">
                                        {{ $action->getLabel() }}
                                    </x-lara-ui::button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="dropdown" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        class="dark:bg-neutral-900 py-2.5 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-blue-600"
                    >
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                        </svg>
                        {!! __('lara-ui::datatable.filters') !!}
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        style="display: none;"
                        class="absolute z-90 min-w-60 bg-white shadow-md rounded-lg dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 mt-2"
                        x-transition
                    >
                        <div class="p-3 space-y-3">
                            @foreach($this->filters() as $filter)
                                <div>
                                    @if($filter->type === 'select')
                                        <x-lara-ui::select.advanced
                                            wire:model.live="activeFilters.{{ $filter->key }}"
                                            :label="$filter->label"
                                            option-label="value"
                                            option-value="key"
                                            :options="collect($filter->options)->map(fn ($value, $key) => ['key' => $key, 'value' => $value])->values()"
                                        />
                                    @elseif($filter->type === 'date')
                                        <x-lara-ui::date
                                            label="{{ $filter->label }}"
                                            wire:model.live="activeFilters.{{ $filter->key }}"
                                        />
                                    @elseif($filter->type === 'text')
                                        <x-lara-ui::input
                                            wire:model.live.debounce.300ms="activeFilters.{{ $filter->key }}"
                                            :label="$filter->label"
                                            type="text"
                                        />
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 dark:border-neutral-700 p-3">
                            <x-lara-ui::button variant="soft" color="error"
                                               class="w-full py-2 flex justify-center items-center"
                                               wire:click="resetFilters">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6L6 18"/>
                                    <path d="M6 6l12 12"/>
                                </svg>
                                {!! __('lara-ui::datatable.clear_filters') !!}
                            </x-lara-ui::button>
                        </div>
                    </div>
                </div>

                @if($options->canModifyItemsPerPage)
                    <x-lara-ui::select.advanced
                        wire:model.live="perPage"
                        option-label="label"
                        option-value="id"
                        class="w-22"
                        :options="collect($options->perPageOptions)->map(fn($value) => [
                            'id' => $value,
                            'label' => $value
                        ])->toArray()"
                    />
                @endif
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full">
                    <thead class="border-y border-gray-200 dark:border-neutral-700">
                    <tr>
                        @if($options->bulkActions)
                            <th scope="col" class="py-1 px-3 pe-0 --exclude-from-ordering">
                                <div class="flex items-center h-5">
                                    <input
                                        wire:model.live="selectAll"
                                        type="checkbox"
                                        class="border-gray-300 rounded-sm text-blue-600 checked:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                    >
                                </div>
                            </th>
                        @endif

                        @foreach($columns as $column)
                            @unless($column->hidden)
                                <th scope="col" class="py-1 group text-start font-normal focus:outline-hidden">
                                    @if($column->sortable)
                                        <button
                                            wire:click="sort('{{ $column->key }}')"
                                            class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md hover:border-gray-200 dark:text-neutral-500 dark:hover:border-neutral-700"
                                        >
                                            {{ $column->label }}
                                            <svg class="size-3.5 ms-1 -me-0.5 text-gray-400 dark:text-neutral-500"
                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    class="{{ $sortField === $column->key && $sortDirection === 'desc' ? 'text-blue-600 dark:text-blue-500' : '' }}"
                                                    d="m7 15 5 5 5-5"/>
                                                <path
                                                    class="{{ $sortField === $column->key && $sortDirection === 'asc' ? 'text-blue-600 dark:text-blue-500' : '' }}"
                                                    d="m7 9 5-5 5 5"/>
                                            </svg>
                                        </button>
                                    @else
                                        <div
                                            class="py-1 px-2.5 inline-flex items-center border border-transparent text-sm text-gray-500 rounded-md">
                                            {{ $column->label }}
                                        </div>
                                    @endif
                                </th>
                            @endunless
                        @endforeach
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse($data as $item)
                        <tr>
                            @if($options->bulkActions)
                                <td class="py-3 ps-3">
                                    <div class="flex items-center h-5">
                                        <input
                                            wire:model.live="selected"
                                            value="{{ $item->id }}"
                                            type="checkbox"
                                            class="border-gray-300 rounded-sm text-blue-600 checked:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                        >
                                    </div>
                                </td>
                            @endif

                            @foreach($columns as $column)
                                <td class="p-3 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                    {!! $column->getValue($item) !!}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + ($options->bulkActions ? 1 : 0) }}"
                                class="p-3 pt-8 text-center text-sm text-gray-500 dark:text-neutral-400">
                                {!! __('lara-ui::datatable.no_results') !!}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap justify-between items-center gap-2 mt-6">
        <div class="flex items-center gap-1">
            <button
                wire:click="previousPage"
                @if(!$data->onFirstPage()) wire:key="paginator-previous" @endif
                type="button"
                class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                {{ $data->onFirstPage() ? 'disabled' : '' }}
            >
                <span aria-hidden="true">«</span>
                <span class="sr-only">{!! __('lara-ui::datatable.pagination_previous') !!}</span>
            </button>

            <div class="flex items-center space-x-1">
                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    <button
                        wire:click="gotoPage({{ $page }})"
                        wire:key="paginator-page-{{ $page }}"
                        type="button"
                        class="p-2.5 min-w-10 inline-flex justify-center items-center text-sm rounded-full {{ $page == $data->currentPage() ? 'bg-gray-100 dark:bg-neutral-700' : 'hover:bg-gray-100 dark:hover:bg-neutral-700' }} text-gray-800 disabled:opacity-50 disabled:pointer-events-none dark:text-white"
                    >
                        {{ $page }}
                    </button>
                @endforeach
            </div>

            <button
                wire:click="nextPage"
                @if(!$data->onLastPage()) wire:key="paginator-next" @endif
                type="button"
                class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                {{ $data->onLastPage() ? 'disabled' : '' }}
            >
                <span class="sr-only">{!! __('lara-ui::datatable.pagination_next') !!}</span>
                <span aria-hidden="true">»</span>
            </button>
        </div>

        <div class="whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
            {!! __('lara-ui::datatable.pagination_text', ['first' => $data->firstItem() ?? 0, 'last' => $data->lastItem() ?? 0, 'total' => $data->total()]) !!}
        </div>
    </div>
</div>
