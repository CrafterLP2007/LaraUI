<?php

namespace CrafterLP2007\LaraUi\Livewire\Table;

use CrafterLP2007\LaraUi\Classes\Table\TableOptions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\SerializesAndRestoresModelIdentifiers;
use Livewire\Component;
use Livewire\WithPagination;

abstract class TableComponent extends Component
{
    use SerializesAndRestoresModelIdentifiers, WithPagination;

    public array $columns = [];

    public array $selected = [];

    public string $search = '';

    public array $activeFilters = [];

    protected TableOptions $options;

    public bool $selectAll = false;

    public int $perPage = 10;

    public string $sortField = '';

    public string $sortDirection = 'asc';

    abstract public function query(): Builder;

    abstract public function columns(): array;

    public function filters(): array
    {
        return [];
    }

    public function bulkActions(): array
    {
        return [];
    }

    protected function setupOptions(): TableOptions
    {
        return TableOptions::make();
    }

    protected function initializeFilters(): void
    {
        foreach ($this->filters() as $filter) {
            $this->activeFilters[$filter->key] = $filter->value;
        }
    }

    protected function applySearch(Builder $query): Builder
    {
        if ($this->options->searchable && $this->search) {
            $searchTerm = strtolower($this->search);

            $records = $query->get();
            $matchingRecords = $records->filter(function ($record) use ($searchTerm) {
                foreach ($this->columns as $column) {
                    if ($column->searchable) {
                        $formattedValue = strtolower($column->getValue($record));
                        if (str_contains($formattedValue, $searchTerm)) {
                            return true;
                        }
                    }
                }

                return false;
            });

            $primaryKey = $query->getModel()->getKeyName();
            $keys = $matchingRecords->pluck($primaryKey)->toArray();

            return $query->whereIn($primaryKey, $keys);
        }

        return $query;
    }

    protected function applyFilters(Builder $query): Builder
    {
        foreach ($this->filters() as $filter) {
            $value = $this->activeFilters[$filter->key] ?? null;
            if ($value !== null && $value !== '') {
                $filter->apply($query, $value);
            }
        }

        return $query;
    }

    public function updatedSelectAll($value): void
    {
        $this->selected = $value ? $this->query()->pluck('id')->map(fn ($id) => (string) $id)->toArray() : [];
    }

    public function executeBulkAction(string $actionLabel): void
    {
        $action = collect($this->bulkActions())->first(fn ($action) => $action->getLabel() === $actionLabel);
        if ($action && ! empty($this->selected)) {
            $rows = $this->query()->get();
            $action->execute($rows);
            $this->selected = [];
            $this->selectAll = false;
        }
    }

    public function updatedSelected(): void
    {
        $this->selectAll = false;
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->activeFilters = [];
        foreach ($this->filters() as $filter) {
            $this->activeFilters[$filter->key] = $filter->value;
        }
    }

    protected function applySort(Builder $query): Builder
    {
        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query;
    }

    public function sort(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
            if ($this->sortDirection === 'asc') {
                $this->sortField = '';
            }
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getDataProperty(): LengthAwarePaginator
    {
        $query = $this->applySort($this->applyFilters($this->applySearch($this->query())));
        $this->columns = collect($this->columns())->filter(fn ($column) => ! $column->hidden)->toArray();

        $perPage = $this->perPage ?? $this->options->perPageOptions[0];

        return $query->paginate($perPage);
    }

    public function boot(): void
    {
        $this->options = $this->setupOptions();
        $this->perPage = $this->options->perPageOptions[0];
    }

    public function mount(): void
    {
        $this->columns = $this->columns();
        $this->initializeFilters();

        $this->search = request()->get('table-search', '');
    }

    public function render(): View
    {
        return view('lara-ui::livewire.components.table.table', [
            'data' => $this->data,
            'columns' => $this->columns,
            'options' => $this->options,
            'bulkActions' => $this->bulkActions(),
        ]);
    }
}
