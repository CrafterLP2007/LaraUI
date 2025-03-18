<?php

namespace CrafterLP2007\LaraUi\Services\Plugins;

abstract class PluginService
{
    protected string $name = '';

    abstract public function install(): void;

    abstract public function installed(): bool;

    public function getName(): string
    {
        return $this->name;
    }
}
