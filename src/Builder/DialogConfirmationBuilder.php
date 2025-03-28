<?php

namespace CrafterLP2007\LaraUi\Builder;

use Closure;
use Exception;

class DialogConfirmationBuilder
{
    protected string $id;

    protected mixed $component;

    protected string $title = '';

    protected string $message = '';

    protected $icon = null;

    protected $onConfirm = null;

    protected $onCancel = null;

    protected array $confirmParams = [];

    protected array $cancelParams = [];

    protected $closeButton = null;

    protected $confirmButton = null;

    public function __construct($component)
    {
        $this->component = $component;
        $this->id = 'lara-ui-confirmation-dialog-'.md5(uniqid());
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function message(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function icon(string $slot): static
    {
        $this->icon = $slot;

        return $this;
    }

    /*

    public function onConfirm(string|callable $method, array $params = []): static
    {
        if (is_callable($method)) {
            $this->onConfirm = $method instanceof Closure
                ? get_class($this->component) . '@handleConfirmCallback'
                : $method;
        } else {
            $this->onConfirm = $method;
        }

        $this->confirmParams = $params;
        return $this;
    }

    public function onCancel(string|callable $method, array $params = []): static
    {
        if (is_callable($method)) {
            $this->onCancel = $method instanceof Closure
                ? get_class($this->component) . '@handleCancelCallback'
                : $method;
        } else {
            $this->onCancel = $method;
        }

        $this->cancelParams = $params;
        return $this;
    }

    */

    public function onConfirm(string|callable|null $method = null, array $params = []): static
    {
        $this->onConfirm = $method;

        $this->confirmParams = $params;

        return $this;
    }

    public function onCancel(string|callable|null $method = null, array $params = []): static
    {
        $this->onCancel = $method;

        $this->cancelParams = $params;

        return $this;
    }

    public function closeButton(string $slot): static
    {
        $this->closeButton = $slot;

        return $this;
    }

    public function confirmButton(string $slot): static
    {
        $this->confirmButton = $slot;

        return $this;
    }

    public function send(): void
    {
        if ($this->onConfirm instanceof Closure) {
            $this->component->handleConfirmCallback = $this->onConfirm;
        }

        if ($this->onCancel instanceof Closure) {
            $this->component->handleCancelCallback = $this->onCancel;
        }

        if (empty($this->title) || empty($this->message)) {
            throw new Exception('Title and message are required for dialog confirmation.');
        }

        $this->component->dispatch('openModal', component: 'lara-ui::dialog-confirmation-modal', arguments: [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'onConfirm' => $this->onConfirm,
            'onCancel' => $this->onCancel,
            'confirmParams' => $this->confirmParams,
            'cancelParams' => $this->cancelParams,
            'closeButton' => $this->closeButton,
            'confirmButton' => $this->confirmButton,
        ]);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getComponent(): mixed
    {
        return $this->component;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return null
     */
    public function getOnConfirm()
    {
        return $this->onConfirm;
    }

    /**
     * @return null
     */
    public function getOnCancel()
    {
        return $this->onCancel;
    }

    public function getConfirmParams(): array
    {
        return $this->confirmParams;
    }

    public function getCancelParams(): array
    {
        return $this->cancelParams;
    }

    /**
     * @return null
     */
    public function getCloseButton()
    {
        return $this->closeButton;
    }

    /**
     * @return null
     */
    public function getConfirmButton()
    {
        return $this->confirmButton;
    }
}
