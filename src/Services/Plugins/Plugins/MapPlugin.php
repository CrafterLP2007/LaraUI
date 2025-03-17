<?php

namespace CrafterLP2007\LaraUi\Services\Plugins\Plugins;

use CrafterLP2007\LaraUi\Services\Plugins\PluginService;
use Illuminate\Support\Facades\Process;
use RuntimeException;
use function Laravel\Prompts\progress;

class MapPlugin extends PluginService
{
    protected string $name = 'Map';

    public function install(): void
    {
        progress(
            label: 'Installing and configuring leaflet',
            steps: [
                'Installing package' => fn () => Process::run('npm install leaflet'),
            ],
            callback: function ($step, $label) {
                $result = $step();

                if ($label === 'Installing package' && !$result->successful()) {
                    throw new RuntimeException('Failed to install leaflet: ' . $result->errorOutput());
                }

                return $result;
            }
        );
    }

    public function installed(): bool
    {
        return file_exists(base_path('node_modules/leaflet'));
    }
}
