<?php

namespace CrafterLP2007\LaraUi\Classes\OffCanvas;

use Livewire\Component;
use CrafterLP2007\LaraUi\Contracts\OffCanvasComponent as Contract;

abstract class OffCanvasComponent extends Component implements Contract
{
    public function closeOffCanvas(bool $force = false): void
    {
        $this->dispatch("closeOffCanvas", force: $force);
    }

    public function closeOffCanvasWithEvents(array $events): void
    {
        $this->emitModalEvents($events);
        $this->closeOffCanvas();
    }

    private function emitModalEvents(array $events): void
    {
        foreach ($events as $component => $event) {
            if (is_array($event)) {
                [$event, $params] = $event;
            }

            if (is_numeric($component)) {
                $this->dispatch($event, ...$params ?? []);
            } else {
                $this->dispatch($event, ...$params ?? [])->to($component);
            }
        }
    }
}
