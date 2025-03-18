<?php

namespace CrafterLP2007\LaraUi;

use CrafterLP2007\LaraUi\Commands\InstallPluginCommand;
use CrafterLP2007\LaraUi\Commands\ReloadCommand;
use CrafterLP2007\LaraUi\Livewire\Modal\ModalComponent;
use CrafterLP2007\LaraUi\Livewire\Notification\Notifications;
use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

use function Livewire\on;
use function Livewire\store;

class LaraUiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lara-ui')
            ->hasConfigFile()
            ->hasViews('lara-ui')
            ->hasTranslations()
            ->hasCommands([
                InstallPluginCommand::class,
                ReloadCommand::class,
            ]);

        // $this->registerComponents();
        $this->registerBladeDirectives();
    }

    public function bootingPackage()
    {
        Livewire::component('lara-ui::modal', ModalComponent::class);
    }

    public function packageBooted(): void
    {
        Livewire::component('notifications', Notifications::class);

        on('dehydrate', function (Component $component) {
            if (! Livewire::isLivewireRequest()) {
                return;
            }

            if (store($component)->has('redirect')) {
                return;
            }

            if (count(session()->get('lara-ui.notifications', [])) > 0) {
                return;
            }

            $component->dispatch('notificationSent');
        });
    }

    public function registerComponents(): void
    {
        // Publish components
        $this->publishes([
            __DIR__.'/../resources/views/components' => resource_path('views/components'),
            __DIR__.'/../src/Services' => app_path('Services'),
        ], 'lara-ui-components');

        // Register individual component directories for publishing separately
        $dirs = array_filter(glob(__DIR__.'/../resources/views/components/*'), 'is_dir');
        foreach ($dirs as $dir) {
            $this->publishes([
                $dir => resource_path('views/components/'.basename($dir)),
            ], 'lara-ui-components-'.basename($dir));
        }

        // Load views from the package
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lara-ui');

        // Register blade components
        $this->app->booted(function () {
            $prefix = config('lara-ui.prefix', '');
            $componentDirs = glob(__DIR__.'/../resources/views/components/*', GLOB_ONLYDIR);

            foreach ($componentDirs as $dir) {
                $componentName = basename($dir);

                // Find the main component file
                $mainFile = null;
                $files = glob("$dir/*.blade.php");

                foreach ($files as $file) {
                    $fileName = pathinfo(basename($file), PATHINFO_FILENAME);
                    if ($fileName === 'index' || $fileName === $componentName) {
                        $mainFile = $fileName;
                        break;
                    }
                }

                // Use first file as fallback
                if (! $mainFile && ! empty($files)) {
                    $mainFile = pathinfo(basename($files[0]), PATHINFO_FILENAME);
                }

                if ($mainFile) {
                    // Register component with proper view path and alias
                    $viewName = "lara-ui::components.$componentName.$mainFile";
                    $alias = $prefix ? "$prefix-$componentName" : $componentName;

                    Blade::component($viewName, $alias);
                }
            }
        });
    }

    public function registerBladeDirectives(): void
    {
        Blade::directive('checkPluginInstalled', function ($expression) {
            $plugin = trim($expression, "'\"");
            if (config('lara-ui.detect_plugins') === true) {
                return "<?php
                        \$isInstalled = app(\CrafterLP2007\LaraUi\LaraUi::class)->hasInstalledPlugin('{$plugin}');
                        if (!\$isInstalled) {
                            throw new Exception('Plugin {$plugin} is not installed! Please run `php artisan lara-ui:install {$plugin}` to install it and use this component.');
                        }
                ?>";
            }

            return null;
        });
    }
}
