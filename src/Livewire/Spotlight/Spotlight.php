<?php

namespace CrafterLP2007\LaraUi\Livewire\Spotlight;

use CrafterLP2007\LaraUi\Classes\Spotlight\SpotlightItem;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Spotlight extends Component
{
    public bool $open = false;

    private \CrafterLP2007\LaraUi\Classes\Spotlight\Spotlight $spotlight;

    public bool $withHistory = false;

    public string $historySessionKey = '';

    public int $maxHistoryItems = 3;

    public int $maxItemsPerCategory = 5;

    public ?string $searchTerm = null;

    public ?Collection $history = null;

    public ?Collection $items = null;

    #[On('toggleSpotlight')]
    public function toggle()
    {
        $this->spotlight = app()->make('spotlight.handler');
        $this->withHistory = $this->spotlight->withHistory();
        $this->historySessionKey = $this->spotlight->getHistorySessionKey();
        $this->maxHistoryItems = $this->spotlight->maxHistoryItems;
        $this->maxItemsPerCategory = $this->spotlight->getMaxItemsPerCategory();

        $options = collect($this->spotlight->getOptions());

        foreach ($options as $item) {
            if (empty($item->getId())) {
                throw new Exception('SpotlightItem ID cannot be empty. Make sure to call build() on each item.');
            }
        }

        $this->items = $options;

        if ($this->spotlight->withHistory()) {
            $this->history = collect($this->getHistory());
        }

        $this->open = true;
    }

    public function getFilteredItems(?string $category = null): Collection
    {
        if (! $this->items) {
            return collect();
        }

        $items = $this->items;

        if ($category) {
            $items = $items->filter(fn ($item) => $item->getCategory() === $category);
        }

        if ($this->searchTerm) {
            return $items->filter(fn ($item) => str_contains(strtolower($item->getLabel()), strtolower($this->searchTerm))
            );
        }

        return $items->take($this->maxItemsPerCategory);
    }

    public function getCategories(): array
    {
        if (! $this->items) {
            return [];
        }

        return $this->items
            ->map(fn ($item) => $item->getCategory())
            ->unique()
            ->values()
            ->toArray();
    }

    public function select($id)
    {
        $item = $this->items->first(function ($item) use ($id) {
            return $item->getId() === $id;
        });

        if (! $item) {
            throw new Exception("SpotlightItem with ID {$id} not found");
        }

        if ($this->withHistory) {
            $this->addToHistory($item);
        }

        $callback = $item->execute();
        if ($callback) {
            $callback();
        }

        $this->close();
    }

    public function clearHistory()
    {
        session()->forget($this->historySessionKey);

        $this->history = collect();
    }

    public function getHistory(): array
    {
        return session()->get($this->historySessionKey, []);
    }

    public function addToHistory(SpotlightItem $item): void
    {
        $history = session()->get($this->historySessionKey, []);
        $newId = $item->getId();

        if (! empty($history) && $history[0] === $newId) {
            return;
        }

        array_unshift($history, $newId);
        session()->put($this->historySessionKey, array_slice($history, 0, $this->maxHistoryItems));
    }

    public function close()
    {
        $this->open = false;
    }

    public function render()
    {
        return view('lara-ui::livewire.components.spotlight.spotlight');
    }
}
