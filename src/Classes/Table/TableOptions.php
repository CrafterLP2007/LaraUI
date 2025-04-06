<?php

namespace CrafterLP2007\LaraUi\Classes\Table;

class TableOptions
{
    public int $perPage = 10;

    public bool $bulkActions = true;

    public bool $searchable = true;

    public bool $canModifyItemsPerPage = true;

    public bool $loading = false;

    public array $perPageOptions = [10, 25, 50, 100];

    public static function make(): static
    {
        return new static;
    }

    public function setPerPage(int $perPage): static
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function setPerPageOptions(array $options): static
    {
        $this->perPageOptions = $options;

        return $this;
    }

    public function withBulkActions(bool $enabled = true): static
    {
        $this->bulkActions = $enabled;

        return $this;
    }

    public function withSearch(bool $enabled = true): static
    {
        $this->searchable = $enabled;

        return $this;
    }

    public function withModifyItemsPerPage(bool $enabled = true): static
    {
        $this->canModifyItemsPerPage = $enabled;

        return $this;
    }

    public function withLoading(bool $enabled = true): static
    {
        $this->loading = $enabled;

        return $this;
    }
}
