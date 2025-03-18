<?php

namespace CrafterLP2007\LaraUi\Services\LaraUI;

use FeatureNinja\Cva\ClassVarianceAuthority;

class ModalCvaService
{
    public static function new(): ClassVarianceAuthority
    {
        return ClassVarianceAuthority::new(
            [
                // Has no class
            ],
            [
                'variants' => [
                    'position' => [
                        'top' => '', // Has no class
                        'centered' => 'min-h-[calc(100%-56px)] flex items-center',
                    ],

                    'size' => [
                        'small' => 'sm:max-w-lg sm:w-full m-3 sm:mx-auto',
                        'medium' => 'md:max-w-2xl md:w-full m-3 md:mx-auto',
                        'large' => 'lg:max-w-4xl lg:w-full m-3 lg:mx-auto',
                    ],

                    'animation' => [
                        'scale' => 'hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 scale-95 opacity-0 ease-in-out transition-all duration-200',
                        'slide-down' => 'hs-overlay-animation-target hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all',
                        'slide-up' => 'hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-14 opacity-0 ease-out transition-all',
                    ],
                ],
            ]
        );
    }
}
