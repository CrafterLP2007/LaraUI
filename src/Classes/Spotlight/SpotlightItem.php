<?php

namespace CrafterLP2007\LaraUi\Classes\Spotlight;

use Laravel\SerializableClosure\SerializableClosure;
use Livewire\Wireable;

class SpotlightItem implements Wireable
{
    private string $id = '';

    private string $label = '';

    private string $icon = '';

    private string $suffix = '';

    private ?string $callbackSerialized = null;

    private bool $hidden = false;

    private string $category = '';

    public static function make(string $category): static
    {
        $instance = new static;

        return $instance->category($category);
    }

    public function category(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function suffix(string $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function action(callable $callback): static
    {
        $this->callbackSerialized = serialize(new SerializableClosure($callback));

        return $this;
    }

    public function hidden(bool $hidden = true): static
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function execute()
    {
        if ($this->callbackSerialized) {
            $callback = unserialize($this->callbackSerialized)->getClosure();

            return $callback();
        }

        return null;
    }

    public function build(): static
    {
        $uniqueString = implode('|', [
            $this->category,
            $this->label,
            $this->icon,
            $this->suffix,
            $this->hidden ? '1' : '0',
        ]);

        $this->id = md5($uniqueString);

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getSuffix(): string
    {
        return $this->suffix;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function toLivewire()
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'icon' => $this->icon,
            'suffix' => $this->suffix,
            'hidden' => $this->hidden,
            'category' => $this->category,
            'callbackSerialized' => $this->callbackSerialized,
        ];
    }

    public static function fromLivewire($value)
    {
        $instance = new static;
        $instance->id = $value['id'];
        $instance->label = $value['label'];
        $instance->icon = $value['icon'];
        $instance->suffix = $value['suffix'];
        $instance->hidden = $value['hidden'];
        $instance->category = $value['category'];
        $instance->callbackSerialized = $value['callbackSerialized'];

        return $instance;
    }
}
