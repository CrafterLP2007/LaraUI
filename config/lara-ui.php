<?php

return [
    /**
     * --------------------------------------------------------------------------
     * LaraUI Component prefix
     * --------------------------------------------------------------------------
     *
     * You can define the prefix for all components for example you change it
     * to 'lara-ui' then all components will be like lara-ui-COMPONENT_NAME
     * If you want to remove the prefix just set it to empty string
     */
    'prefix' => '',

    /**
     * --------------------------------------------------------------------------
     * Detect Plugins
     * --------------------------------------------------------------------------
     *
     * LaraUI has a plugin system by preline for components. If you want to
     * automatically detect and install plugins for components set this to
     * true. If you want to manually install plugins set this to false.
     * If you change this value you maybe need to run `php artisan lara-ui:reload`
     */
    'detect_plugins' => true,
];
