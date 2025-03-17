<?php

namespace CrafterLP2007\LaraUi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CrafterLP2007\LaraUi\LaraUi
 */
class LaraUi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \CrafterLP2007\LaraUi\LaraUi::class;
    }
}
