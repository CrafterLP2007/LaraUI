<?php

namespace CrafterLP2007\LaraUi\Classes\Table\Filter;

class SelectFilter extends Filter
{
    public array $options = [];

    public function __construct()
    {
        $this->type = 'select';
    }

    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }
}
