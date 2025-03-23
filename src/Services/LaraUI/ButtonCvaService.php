<?php

namespace CrafterLP2007\LaraUi\Services\LaraUI;

use FeatureNinja\Cva\ClassVarianceAuthority;

class ButtonCvaService
{
    public static function new(): ClassVarianceAuthority
    {
        return ClassVarianceAuthority::new(
            [
                'py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none cursor-pointer',
            ],
            [
                'variants' => [
                    'solid' => [
                        'neutral' => 'border-transparent bg-gray-500 text-white hover:bg-gray-600 focus:bg-gray-600',
                        'success' => 'border-transparent bg-teal-500 text-white hover:bg-teal-600 focus:bg-teal-600',
                        'error' => 'border-transparent bg-red-500 text-white hover:bg-red-600 focus:bg-red-600',
                        'warning' => 'border-transparent bg-yellow-500 text-white hover:bg-yellow-600 focus:bg-yellow-600',
                        'secondary' => 'border-transparent bg-white text-gray-800 hover:bg-gray-200 focus:bg-gray-200',
                        'primary' => 'border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700',
                        'white' => 'border-transparent bg-gray-800 text-white hover:bg-gray-900 focus:bg-gray-900',
                    ],
                    'outline' => [
                        'neutral' => 'border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:border-gray-800 focus:text-gray-800 dark:border-neutral-400 dark:text-neutral-400 dark:hover:text-neutral-300 dark:hover:border-neutral-300',
                        'success' => 'border-teal-500 text-teal-500 hover:border-teal-400 hover:text-teal-400 focus:border-teal-400 focus:text-teal-400',
                        'error' => 'border-red-500 text-red-500 hover:border-red-400 hover:text-red-400 focus:border-red-400 focus:text-red-400',
                        'warning' => 'border-yellow-500 text-yellow-500 hover:border-yellow-400 hover:text-yellow-400 focus:border-yellow-400 focus:text-yellow-400',
                        'secondary' => 'border-white text-white hover:border-white/70 hover:text-white/70 focus:border-white/70 focus:text-white/70',
                        'primary' => 'border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:border-blue-500 focus:text-blue-500 dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400',
                        'white' => 'border-gray-800 text-gray-800 hover:border-gray-500 hover:text-gray-500 focus:border-gray-500 focus:text-gray-500',
                    ],
                    'ghost' => [
                        'neutral' => 'border-transparent text-gray-500 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800',
                        'success' => 'border-transparent text-teal-500 hover:bg-teal-100 focus:bg-teal-100 hover:text-teal-800 dark:hover:bg-teal-800/30 dark:hover:text-teal-400 dark:focus:text-teal-400',
                        'error' => 'border-transparent text-red-500 hover:bg-red-100 focus:bg-red-100 hover:text-red-800 dark:hover:bg-red-800/30 dark:hover:text-red-400 dark:focus:bg-red-800/30 dark:focus:text-red-400',
                        'warning' => 'border-transparent text-yellow-500 hover:bg-yellow-100 focus:bg-yellow-100 hover:text-yellow-800 dark:hover:bg-yellow-800/30 dark:hover:text-yellow-400 dark:focus:bg-yellow-800/30 dark:focus:text-yellow-400',
                        'secondary' => 'border-transparent text-white hover:bg-gray-100 focus:bg-gray-100 hover:text-gray-800 dark:hover:bg-white/10 dark:hover:text-white dark:focus:bg-white/10 dark:focus:text-white',
                        'primary' => 'border-transparent text-blue-600 hover:bg-blue-100 focus:bg-blue-100 hover:text-blue-800 focus:text-blue-800 dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:text-blue-400 dark:focus:bg-blue-800/30 dark:focus:text-blue-400',
                        'white' => 'border-transparent text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700',
                    ],
                    'soft' => [
                        'neutral' => 'border-transparent bg-gray-100 text-gray-500 hover:bg-gray-200 focus:bg-gray-200 dark:bg-white/10 dark:text-neutral-400 dark:hover:bg-white/20 dark:hover:text-neutral-300 dark:focus:bg-white/20 dark:focus:text-neutral-300',
                        'success' => 'border-transparent bg-teal-100 text-teal-800 hover:bg-teal-200 focus:bg-teal-200 dark:text-teal-500 dark:bg-teal-800/30 dark:hover:bg-teal-800/20 dark:focus:bg-teal-800/20',
                        'primary' => 'border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:bg-blue-200 dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20',
                        'error' => 'border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:bg-red-200 dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20',
                        'warning' => 'border-transparent bg-yellow-100 text-yellow-800 hover:bg-yellow-200 focus:bg-yellow-200 dark:text-yellow-500 dark:bg-yellow-800/30 dark:hover:bg-yellow-800/20 dark:focus:bg-yellow-800/20',
                        'secondary' => 'border-transparent bg-white/10 text-white hover:bg-white/20 focus:bg-white/20',
                        'white' => 'border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:bg-gray-200 dark:bg-white/10 dark:text-white dark:hover:bg-white/20 dark:hover:text-white dark:focus:bg-white/20 dark:focus:text-white',
                    ],
                    'white' => [
                        'neutral' => 'border-gray-200 bg-white text-gray-500 shadow-2xs hover:bg-gray-50 focus:bg-gray-50 dark:bg-neutral-800 dark:text-neutral-400 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700',
                        'success' => 'border-gray-200 bg-white text-teal-500 shadow-2xs hover:bg-gray-50 focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700',
                        'primary' => 'border-gray-200 bg-white text-blue-600 shadow-2xs hover:bg-gray-50 focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-blue-500',
                        'error' => 'border-gray-200 bg-white text-red-500 shadow-2xs hover:bg-gray-50 focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700',
                        'warning' => 'border-gray-200 bg-white text-yellow-500 shadow-2xs hover:bg-gray-50 focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700',
                        'white' => 'border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700',
                    ],
                    'link' => [
                        'neutral' => 'py-0 px-0 border-0 text-gray-500 hover:text-blue-600 focus:text-blue-600 dark:text-neutral-400 dark:hover:text-white dark:focus:text-white font-semibold',
                        'primary' => 'py-0 px-0 border-0 text-blue-600 hover:text-blue-800 focus:text-blue-800 dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400 font-semibold',
                        'secondary' => 'py-0 px-0 border-0 text-white hover:text-white/80 focus:text-white/80 font-semibold',
                        'white' => 'py-0 px-0 border-0 text-gray-800 hover:text-blue-600 focus:text-blue-600 dark:text-white dark:hover:text-white/70 dark:focus:text-white/70 font-semibold',
                    ],
                ],
            ]
        );
    }
}
