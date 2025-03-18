<?php

namespace CrafterLP2007\LaraUi\Builder;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class NotificationBuilder implements Arrayable
{
    public string $id = "";
    public string $variant = "solid";
    public string $color = "white";
    public string $title = "";
    public string $message = "";
    public string $icon = "";
    public bool $dismissable = false;
    public string $link = "";
    public bool $navigate = false;
    public int $timeout = 5;

    public function __construct($id)
    {
        if (empty($id)) {
            $this->id = "lara-ui-notification-" . Str::orderedUuid();
            return;
        }

        $this->id = $id;
    }

    public static function make(string $id = ""): static
    {
        return new static($id);
    }

    public function solid(): static
    {
        $this->variant('solid');

        return $this;
    }

    public function soft(): static
    {
        $this->variant('solid');

        return $this;
    }

    public function dark(): static
    {
        $this->color("dark");

        return $this;
    }

    public function secondary(): static
    {
        $this->color("secondary");

        return $this;
    }

    public function info(): static
    {
        $this->color("info");

        return $this;
    }

    public function success(): static
    {
        $this->color("success");

        return $this;
    }

    public function danger(): static
    {
        $this->color("danger");

        return $this;
    }

    public function warning(): static
    {
        $this->color("warning");

        return $this;
    }

    public function light(): static
    {
        $this->color("light");

        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function variant(string $variant): static
    {
        $this->variant = $variant;

        return $this;
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

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function canDismiss(bool $dismissable): static
    {
        $this->dismissable = $dismissable;

        return $this;
    }

    public function dismissable(): static
    {
        $this->canDismiss(true);

        return $this;
    }

    public function link(string $link, bool $navigate = false): static
    {
        $this->link = $link;
        $this->navigate = $navigate;

        return $this;
    }

    public function timeout(int $seconds): static
    {
        $this->timeout = $seconds;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'variant' => $this->variant,
            'color' => $this->color,
            'dismissable' => $this->dismissable,
            'link' => $this->link,
            'navigate' => $this->navigate,
            'timeout' => $this->timeout,
        ];
    }

    public static function fromArray(array $data): static
    {
        $static = static::make($data['id'] ?? Str::random());

        if (
            ($static::class !== self::class) &&
            (get_called_class() === self::class)
        ) {
            return $static::fromArray($data);
        }

        $static->title = $data['title'] ?? "";
        $static->message = $data['message'] ?? "";
        $static->icon = $data['icon'] ?? "";
        $static->variant = $data['variant'] ?? "solid";
        $static->color = $data['color'] ?? "white";
        $static->dismissable = $data['dismissable'] ?? false;
        $static->link = $data['link'] ?? "";
        $static->navigate = $data['navigate'] ?? false;
        $static->timeout = $data['timeout'] ?? 5;

        return $static;
    }

    public function send(): void
    {
        session()->push(
            'lara-ui.notifications',
            $this->toArray()
        );
    }
}
