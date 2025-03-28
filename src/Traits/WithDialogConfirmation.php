<?php

namespace CrafterLP2007\LaraUi\Traits;

use CrafterLP2007\LaraUi\Builder\DialogConfirmationBuilder;
use Livewire\Attributes\On;

trait WithDialogConfirmation
{
    public function dialog(): DialogConfirmationBuilder
    {
        return new DialogConfirmationBuilder($this);
    }

    #[On('dialog.confirmed')]
    public function onConfirm($event): void
    {
        if (! isset($event['callback']) || $event['callback'] === null) {
            $this->handleConfirmCallback($event['params'] ?? []);

            return;
        }

        if (is_string($event['callback']) && method_exists($this, $event['callback'])) {
            $this->{$event['callback']}(...($event['params'] ?? []));
        }
    }

    #[On('dialog.cancelled')]
    public function onCancel($event): void
    {
        if (! isset($event['callback']) || $event['callback'] === null) {
            $this->handleCancelCallback($event['params'] ?? []);

            return;
        }

        if (is_string($event['callback']) && method_exists($this, $event['callback'])) {
            $this->{$event['callback']}(...($event['params'] ?? []));
        }
    }

    /**
     * Handle the callback in a function when
     * user click on the confirm button
     *
     * @param  array  $params
     * @return void
     */
    public function handleConfirmCallback(...$params) {}

    /**
     * Handle the callback in a function when
     * user click on the cancel button
     *
     * @param  array  $params
     * @return void
     */
    public function handleCancelCallback(...$params) {}
}
