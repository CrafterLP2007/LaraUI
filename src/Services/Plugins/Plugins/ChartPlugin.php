<?php

namespace CrafterLP2007\LaraUi\Services\Plugins\Plugins;

use CrafterLP2007\LaraUi\Services\Plugins\PluginService;
use Illuminate\Support\Facades\Process;
use RuntimeException;
use function Laravel\Prompts\progress;

class ChartPlugin extends PluginService
{
    protected string $name = 'Chart';

    public function install(): void
    {
        progress(
            label: 'Installing and configuring apexcharts',
            steps: [
                'Installing package' => fn () => Process::run('npm install apexcharts'),
                'Updating app.js' => function () {
                    $appJs = file_get_contents(base_path('resources/js/app.js'));
                    $code = "\nimport ApexCharts from 'apexcharts'\nwindow.ApexCharts = ApexCharts;\n";

                    if (!str_contains($appJs, "import ApexCharts from 'apexcharts'")) {
                        file_put_contents(base_path('resources/js/app.js'), $appJs . $code);
                    }
                    return true;
                }
            ],
            callback: function ($step, $label) {
                $result = $step();

                if ($label === 'Installing package' && !$result->successful()) {
                    throw new RuntimeException('Failed to install apexcharts: ' . $result->errorOutput());
                }

                return $result;
            }
        );
    }

    public function installed(): bool
    {
        return file_exists(base_path('node_modules/apexcharts'));
    }
}
