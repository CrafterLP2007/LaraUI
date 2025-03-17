<?php

namespace CrafterLP2007\LaraUi\Services\Plugins;

use PHPStan\ExtensionInstaller\Plugin;

abstract class PluginService
{
    protected string $name = '';

    public abstract function install(): void;

    public abstract function installed(): bool;

    public function getName(): string
    {
        return $this->name;
    }
}
