<?php

namespace CrafterLP2007\LaraUi\Commands;

use CrafterLP2007\LaraUi\LaraUiServiceProvider;
use Illuminate\Console\Command;
use function Laravel\Prompts\progress;

class ReloadCommand extends Command
{
    public $signature = 'lara-ui:reload';

    public $description = 'Reload the LaraUI package';

    public function handle(): int
    {
        $steps = [
            'Clearing view cache' => function() {
                $this->callSilently('view:clear');
                return true;
            },
            'Reloading service provider' => function() {
                $provider = new LaraUiServiceProvider(app());
                $provider->registerComponents();
                $provider->registerBladeDirectives();
                return true;
            }
        ];

        progress(
            label: "Reloading LaraUI package",
            steps: $steps,
            callback: function ($step) {
                return $step();
            }
        );

        $this->info('LaraUI package reloaded successfully.');
        return self::SUCCESS;
    }
}
