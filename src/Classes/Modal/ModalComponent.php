<?php

namespace CrafterLP2007\LaraUi\Classes\Modal;

use CrafterLP2007\LaraUi\Contracts\ModalComponent as Contract;
use Livewire\Component;

abstract class ModalComponent extends Component implements Contract
{
    public function closeModal(bool $force = false): void
    {
        $this->dispatch('closeModal', force: $force);
    }

    public function closeModalWithEvents(array $events): void
    {
        $this->emitModalEvents($events);
        $this->closeModal();
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
