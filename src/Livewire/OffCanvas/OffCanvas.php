<?php

namespace CrafterLP2007\LaraUi\Livewire\OffCanvas;

use CrafterLP2007\LaraUi\Contracts\OffCanvasComponent;
use Exception;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Reflector;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Mechanisms\ComponentRegistry;
use ReflectionClass;
use ReflectionProperty;

class OffCanvas extends Component
{
    public ?string $activeComponent;

    public array $components = [];

    public function resetState(): void
    {
        $this->components = [];
        $this->activeComponent = null;
    }

    #[On('openOffcanvas')]
    public function openOffCanvas($component, $arguments = [], $attributes = []): void
    {
        $requiredInterface = OffCanvasComponent::class;
        $componentClass = app(ComponentRegistry::class)->getClass($component);
        $reflect = new ReflectionClass($componentClass);

        if ($reflect->implementsInterface($requiredInterface) === false) {
            throw new Exception("[{$componentClass}] does not implement [{$requiredInterface}] interface.");
        }

        $id = md5($component.serialize($arguments));

        $arguments = collect($arguments)
            ->merge($this->resolveComponentProps($arguments, new $componentClass))
            ->all();

        $this->components[$id] = [
            'name' => $component,
            'arguments' => $arguments,
            'attributes' => array_merge([
                'position' => 'left',
                'closeOnEscape' => true,
            ], $attributes),
        ];

        $this->activeComponent = $id;

        $this->dispatch('activeOffCanvasComponentChanged', id: $id);
    }

    public function closeOffCanvas(bool $force = false): void
    {
        $this->dispatch('closeOffcanvas', force: $force);
    }

    public function resolveComponentProps(array $attributes, Component $component): Collection
    {
        return $this->getPublicPropertyTypes($component)
            ->intersectByKeys($attributes)
            ->map(function ($className, $propName) use ($attributes) {
                $resolved = $this->resolveParameter($attributes, $propName, $className);

                return $resolved;
            });
    }

    protected function resolveParameter($attributes, $parameterName, $parameterClassName)
    {
        $parameterValue = $attributes[$parameterName];

        if ($parameterValue instanceof UrlRoutable) {
            return $parameterValue;
        }

        if (enum_exists($parameterClassName)) {
            $enum = $parameterClassName::tryFrom($parameterValue);

            if ($enum !== null) {
                return $enum;
            }
        }

        $instance = app()->make($parameterClassName);

        if (! $model = $instance->resolveRouteBinding($parameterValue)) {
            throw (new ModelNotFoundException)->setModel(get_class($instance), [$parameterValue]);
        }

        return $model;
    }

    public function getPublicPropertyTypes($component): Collection
    {
        return collect($component->all())
            ->map(function ($value, $name) use ($component) {
                return Reflector::getParameterClassName(new ReflectionProperty($component, $name));
            })
            ->filter();
    }

    #[On('destroyComponent')]
    public function destroyComponent($id): void
    {
        unset($this->components[$id]);
    }

    public function render()
    {
        return view('lara-ui::livewire.components.offcanvas.offcanvas');
    }
}
