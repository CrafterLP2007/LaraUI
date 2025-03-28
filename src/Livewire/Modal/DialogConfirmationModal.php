<?php

namespace CrafterLP2007\LaraUi\Livewire\Modal;

use Illuminate\Contracts\View\View;

class DialogConfirmationModal extends ModalComponent implements \CrafterLP2007\LaraUi\Contracts\ModalComponent
{
    public string $id = '';
    public string $title = '';
    public string $message = '';
    public $icon = null;
    public $onConfirm = null;
    public $onCancel = null;
    public array $confirmParams = [];
    public array $cancelParams = [];
    public $closeButton = null;
    public $confirmButton = null;

    public function confirm(): void
    {
        $this->dispatch('dialog.confirmed', [
            'id' => $this->id,
            'callback' => $this->onConfirm,
            'params' => $this->confirmParams,
        ]);

        $this->closeModal();
    }

    public function cancel(): void
    {
        $this->dispatch('dialog.cancelled', [
            'id' => $this->id,
            'callback' => $this->onCancel,
            'params' => $this->cancelParams,
        ]);

        $this->closeModal();
    }

    public function close(): void
    {
        if ($this->cancelOnClose) {
            $this->cancel();
            return;
        }

        $this->closeModal();
    }

    public function render(): View
    {
        return view('lara-ui::livewire.components.modals.dialog-confirmation-modal');
    }
}
