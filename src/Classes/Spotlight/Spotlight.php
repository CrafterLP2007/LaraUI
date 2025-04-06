<?php

namespace CrafterLP2007\LaraUi\Classes\Spotlight;

use Exception;

abstract class Spotlight
{
    public bool $withHistory = true;
    public int $maxHistoryItems = 3;
    public int $maxItemsPerCategory = 5;
    public string $historySessionKey = 'spotlight.history';

    public abstract function options(): array;

    public function clearHistory(): void
    {
        session()->forget($this->historySessionKey);
    }

    public function withHistory(): bool
    {
        return $this->withHistory;
    }

    public function getOptions(): array
    {
        return $this->options();
    }

    public function getHistorySessionKey(): string
    {
        return $this->historySessionKey;
    }

    public function getMaxItemsPerCategory(): int
    {
        return $this->maxItemsPerCategory;
    }

    /**
     * @throws Exception
     */
    public static function register($class): void
    {
        if (!class_exists($class)) {
            throw new Exception("Class $class does not exist.");
        }

        if (!is_subclass_of($class, self::class)) {
            throw new Exception("Class $class is not a subclass of " . self::class);
        }

        if (app()->bound('spotlight.handler')) {
            app()->forgetInstance('spotlight.handler');
        }

        app()->singleton('spotlight.handler', $class);
    }
}
