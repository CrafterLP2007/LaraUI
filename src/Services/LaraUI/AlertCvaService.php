<?php

namespace CrafterLP2007\LaraUi\Services\LaraUI;

use FeatureNinja\Cva\ClassVarianceAuthority;

class AlertCvaService
{
    public static function new(): ClassVarianceAuthority
    {
        return ClassVarianceAuthority::new(
            [
                'mt-2 text-sm text-white p-4 rounded-lg',
            ],
            [
                'variants' => [
                    'solid' => [
                        'primary' => 'bg-blue-500 text-white dark:bg-blue-600',
                        'neutral' => 'bg-gray-800 text-white dark:bg-white dark:text-neutral-800',
                        'secondary' => 'bg-gray-500 text-white',
                        'info' => 'bg-blue-600 text-white dark:bg-blue-500',
                        'success' => 'bg-teal-500 text-white',
                        'error' => 'bg-red-500 text-white',
                        'warning' => 'bg-yellow-500 text-white',
                        'light' => 'bg-white text-gray-600',
                    ],

                    'soft' => [
                        'primary' => 'bg-blue-100 border border-blue-200 text-blue-800 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500',
                        'neutral' => 'bg-gray-100 border border-gray-200 text-gray-800 dark:bg-white/10 dark:border-white/20 dark:text-white',
                        'secondary' => 'bg-gray-50 border border-gray-200 text-gray-600 dark:bg-white/10 dark:border-white/10 dark:text-neutral-400',
                        'info' => 'bg-blue-100 border border-blue-200 text-blue-800 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500',
                        'success' => 'bg-teal-100 border border-teal-200 text-teal-800 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500',
                        'error' => 'bg-red-100 border border-red-200 text-red-800 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500',
                        'warning' => 'bg-yellow-100 border border-yellow-200 text-yellow-800 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500',
                        'light' => 'bg-white/10 border border-white/10 text-white',
                    ],
                ],
            ]
        );
    }
}
