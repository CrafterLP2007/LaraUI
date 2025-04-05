<?php

namespace CrafterLP2007\LaraUi\Builder\Chart;

class SeriesBuilder
{
    protected string $name;
    protected array $data = [];
    protected array $labels = [];
    protected ?string $color = null;

    public static function make(string $name = ''): static
    {
        return (new static())->name($name);
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function data(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function labels(array $labels): static
    {
        $this->labels = $labels;
        return $this;
    }

    public function addPoint(string|int $label, int|float $value): static
    {
        $this->data[] = $value;
        $this->labels[] = $label;
        return $this;
    }

    public function addPoints(array $points): static
    {
        foreach ($points as $label => $value) {
            $this->addPoint($label, $value);
        }
        return $this;
    }

    public function getSeries(): array
    {
        $series = [
            'name' => $this->name,
            'data' => $this->data
        ];

        if ($this->color !== null) {
            $series['color'] = $this->color;
        }

        return $series;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }
}
