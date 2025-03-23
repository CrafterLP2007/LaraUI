<?php

use CrafterLP2007\LaraUi\Builder\NotificationBuilder;

if (! function_exists('notification')) {
    function notification($id = null): NotificationBuilder
    {
        return new NotificationBuilder($id);
    }
}
