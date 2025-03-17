<?php

namespace CrafterLP2007\LaraUi\Services\LaraUI;

use FeatureNinja\Cva\ClassVarianceAuthority;

class SpinnerCvaService
{
    public static function new(): ClassVarianceAuthority
    {
        return ClassVarianceAuthority::new(
            [
                'animate-spin inline-block border-3 border-current border-t-transparent rounded-full'
            ],
            [
                'variants' => [
                    'variant' => [
                        'neutral' => 'text-gray-800 dark:text-white',
                        'muted' => 'text-gray-400',
                        'primary' => 'text-blue-600 dark:text-blue-500',
                        'success' => 'text-green-600',
                        'warning' => 'text-yellow-600',
                        'error' => 'text-red-600',
                        'indigo' => 'text-indigo-600',
                        'purple' => 'text-purple-600',
                        'pink' => 'text-pink-600',
                        'orange' => 'text-orange-600'
                    ],

                    'size' => [
                        'small' => 'size-4',
                        'default' => 'size-6',
                        'large' => 'size-8'
                    ]
                ],
            ]
        );
    }
}
