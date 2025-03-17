<?php

namespace CrafterLP2007\LaraUi;

use Illuminate\Support\Collection;
use RuntimeException;

class LaraUi {

    public function version(): void
    {
        json_decode(file_get_contents(base_path('composer.json')), true)['version'];
    }

    public function plugins(): Collection
    {
        $pluginDirectory = __DIR__ . '/Services/Plugins/Plugins';
        $pluginFiles = glob($pluginDirectory . '/*Plugin.php');

        $plugins = collect();
        foreach ($pluginFiles as $file) {
            $className = 'CrafterLP2007\\LaraUi\\Services\\Plugins\\Plugins\\' . basename($file, '.php');
            if (class_exists($className)) {
                $instance = new $className();
                $plugins->put($instance->getName(), $instance);
            }
        }

        return $plugins;
    }

    public function hasInstalledPlugin(string $name): bool
    {
        $plugin = $this->plugins()->get($name);
        if (!$plugin) {
            throw new RuntimeException("Plugin '$name' not found");
        }

        if (!method_exists($plugin, 'installed')) {
            throw new RuntimeException("Plugin '$name' does not implement isInstalled method");
        }

        return $plugin->installed();
    }

    public function installPlugin(string $name): void
    {
        $plugin = $this->plugins()->get($name);
        if (!$plugin) {
            throw new RuntimeException("Plugin '$name' not found");
        }

        if (!method_exists($plugin, 'install')) {
            throw new RuntimeException("Plugin '$name' does not implement install method");
        }

        $plugin->install();
    }
}
