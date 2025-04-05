<?php

namespace CrafterLP2007\LaraUi\Classes\Table\Filter;

class BooleanFilter extends Filter
{
    public function __construct()
    {
        $this->type = 'select';
        $this->options = [
            'true' => 'Yes',
            'false' => 'No',
        ];

        $this->filter(function (Builder $builder, $value) {
            if ($value === 'true') {
                $builder->whereNotNull($this->key);
            } elseif ($value === 'false') {
                $builder->whereNull($this->key);
            }
        });
    }

    public function allLabel(string $label): static
    {
        $this->options[''] = $label;

        return $this;
    }

    public function trueLabel(string $label): static
    {
        $this->options['true'] = $label;

        return $this;
    }

    public function falseLabel(string $label): static
    {
        $this->options['false'] = $label;

        return $this;
    }
}
