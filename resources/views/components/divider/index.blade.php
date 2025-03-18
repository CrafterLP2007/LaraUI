@props([
    'position' => 'horizontal',
])

@if($position === 'horizontal')
    <div class="py-3 flex items-center text-sm text-gray-800 dark:text-white
        before:flex-1 before:border-t before:border-gray-200 before:me-6 dark:before:border-neutral-600
        after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:after:border-neutral-600">
        {{ $slot }}
    </div>
@elseif($position === 'vertical')
    <div class="flex w-full h-full justify-center">
        <div class="flex flex-col items-center relative">
            <div class="w-px h-full bg-gray-200 dark:bg-neutral-600 absolute"></div>
            <div class="absolute top-1/2 -translate-y-1/2 bg-white dark:bg-neutral-900 px-2 text-sm py-3">
                {{ $slot }}
            </div>
        </div>
    </div>
@endif
