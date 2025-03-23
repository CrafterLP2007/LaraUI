@props([
    'index',
])

<li class="flex items-center gap-x-2 shrink basis-0 flex-1 group"
    :class="goToStepByClick ? 'cursor-pointer' : ''"
    data-step-index="{{ $index }}"
    @click="if (goToStepByClick) goToStep({{ $index }})">
    <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
        <span x-bind:class="{
            'size-7 flex justify-center items-center shrink-0 font-medium rounded-full': true,
            'bg-blue-600 text-white': step == {{ $index }},
            'bg-teal-500 text-white': step > {{ $index }},
            'bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-white': step < {{ $index }}
        }">
            <span x-show="step > {{ $index }}"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 scale-0"
                  x-transition:enter-end="opacity-100 scale-100"
                  style="display: none;">
                <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
            <span x-show="step <= {{ $index }}"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 scale-0"
                  x-transition:enter-end="opacity-100 scale-100"
                  style="display: none;">
                {{ $index }}
            </span>
        </span>
        <span class="ms-2 text-sm font-medium text-gray-800 dark:text-white">
            {{ $slot }}
        </span>
    </span>
    <div x-bind:class="{
        'w-full h-px flex-1 group-last:hidden': true,
        'bg-teal-500': step > {{ $index }},
        'bg-blue-600': step == {{ $index }},
        'bg-gray-200 dark:bg-neutral-600': step < {{ $index }}
    }"></div>
</li>
