<?php

namespace CrafterLP2007\LaraUi\Services\LaraUI;

use FeatureNinja\Cva\ClassVarianceAuthority;

class InputCvaService
{
    public static function new(): ClassVarianceAuthority
    {
        return ClassVarianceAuthority::new(
            [
                'w-full sm:text-sm disabled:opacity-50 disabled:pointer-events-none',
            ],
            [
                'variants' => [
                    'default' => [
                        'default' => 'py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600',
                        'gray' => 'py-2.5 sm:py-3 px-4 block w-full bg-gray-100 border-transparent rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600',
                        'underline' => 'py-2.5 sm:py-3 block bg-transparent border-t-transparent border-b-2 border-x-transparent border-b-gray-200 focus:border-t-transparent focus:border-x-transparent focus:border-b-blue-500 focus:ring-0 dark:border-b-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 dark:focus:border-b-neutral-600',
                        'error' => 'py-2.5 sm:py-3 px-4 block w-full border-red-500 rounded-lg sm:text-sm focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600',
                    ],
                    'floating' => [
                        'default' => 'peer p-4 block border-gray-200 rounded-lg placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 not-placeholder-shown:pt-6 not-placeholder-shown:pb-2 autofill:pt-6 autofill:pb-2',
                        'gray' => 'peer p-4 block bg-gray-100 border-transparent rounded-lg placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 not-placeholder-shown:pt-6 not-placeholder-shown:pb-2 autofill:pt-6 autofill:pb-2',
                        'underline' => 'peer py-4 px-0 block bg-transparent border-t-transparent border-b-2 border-x-transparent border-b-gray-200 placeholder:text-transparent focus:border-t-transparent focus:border-x-transparent focus:border-b-blue-500 focus:ring-0 dark:border-b-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600 dark:focus:border-b-neutral-600 focus:pt-6 focus:pb-2 not-placeholder-shown:pt-6 not-placeholder-shown:pb-2 autofill:pt-6 autofill:pb-2',
                        'error' => 'peer p-4 block border-red-500 rounded-lg placeholder:text-transparent focus:border-red-500 focus:ring-red-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600 focus:pt-6 focus:pb-2 not-placeholder-shown:pt-6 not-placeholder-shown:pb-2 autofill:pt-6 autofill:pb-2',
                    ],
                ],
            ]
        );
    }
}
