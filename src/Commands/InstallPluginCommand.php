<?php

namespace CrafterLP2007\LaraUi\Commands;

use CrafterLP2007\LaraUi\Facades\LaraUi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use function Laravel\Prompts\multiselect;

class InstallPluginCommand extends Command
{
    protected $signature = 'lara-ui:install {plugin?*} {--args=*}';

    public $description = 'Install a preline plugin';

    public function handle(): int
    {
        $plugins = LaraUi::plugins();
        $inputPlugins = $this->argument('plugin');
        $args = $this->option('args');

        if (empty($inputPlugins)) {
            $availablePlugins = $plugins->reject(function ($plugin) {
                return $plugin->installed();
            })->mapWithKeys(function ($plugin) {
                return [$plugin->getName() => $plugin->getName()];
            })->toArray();

            if (empty($availablePlugins)) {
                $this->info('All plugins are already installed!');

                return self::SUCCESS;
            }

            $selectedPlugins = multiselect(
                label: 'Select plugins to install',
                options: $availablePlugins,
                default: []
            );
        } else {
            $selectedPlugins = $inputPlugins;
        }

        foreach ($selectedPlugins as $plugin) {
            if (! $plugins->has($plugin)) {
                $this->error("Plugin '$plugin' not found!");

                continue;
            }

            if ($plugins->get($plugin)->installed()) {
                $this->warn("Plugin '$plugin' is already installed!");

                continue;
            }

            LaraUi::installPlugin($plugin);
            $this->info("Plugin '$plugin' installed successfully!");
        }

        Artisan::call('lara-ui:reload');

        return self::SUCCESS;
    }
}
