<?php

namespace CrafterLP2007\LaraUi\Livewire\Notification;

use CrafterLP2007\LaraUi\Builder\NotificationBuilder;
use CrafterLP2007\LaraUi\Collection\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class Notifications extends Component
{
    public Collection $notifications;

    protected $listeners = [
        'notificationSent' => ['pullNotifications', 'pushNotificationFromEvent'],
        'notificationClosed' => 'removeNotification',
    ];

    #[On('notificationSent')]
    public function pullNotifications()
    {
        foreach (session()->pull('lara-ui.notifications') ?? [] as $notification) {
            $notification = NotificationBuilder::fromArray($notification);

            $this->pushNotification($notification);
        }
    }

    #[On('notificationSent')]
    public function pushNotificationFromEvent(array $notification): void
    {
        $notification = Notification::fromArray($notification);

        $this->pushNotification($notification);
    }

    #[On('notificationClosed')]
    public function removeNotification(string $id): void
    {
        if (! $this->notifications->has($id)) {
            return;
        }

        $this->notifications->forget($id);
    }

    protected function pushNotification(NotificationBuilder $notification): void
    {
        $this->notifications->put(
            $notification->getId(),
            $notification,
        );

        $this->dispatch('notification-added');
    }

    public function getUser(): Model|Authenticatable|null
    {
        return auth(static::$authGuard)->user();
    }

    public function mount()
    {
        $this->notifications = new Collection;
        $this->pullNotifications();
    }

    public function render()
    {
        return view('lara-ui::livewire.components.notification.notifications');
    }
}
