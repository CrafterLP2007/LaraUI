<div class="size-full">
    <div
        class="relative flex flex-col overflow-hidden rounded-lg max-w-3xl mx-auto"
    >
    <div class="p-4 sm:p-10 overflow-y-auto">
            <div class="flex gap-x-4 md:gap-x-7">
                @if(!$icon)
                    <span
                        class="shrink-0 inline-flex justify-center items-center size-11 sm:w-15.5 sm:h-15.5 rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </span>
                @else
                    <div class="shrink-0">
                        {!! $icon !!}
                    </div>
                @endif

                <div class="grow">
                    <h3 class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                        {!!$title !!}
                    </h3>
                    <p class="text-gray-500 dark:text-neutral-500">
                        {!! $message !!}
                    </p>
                </div>
            </div>
        </div>

        <div
            class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t border-gray-200 dark:bg-neutral-950 dark:border-neutral-800">
            @if(!$closeButton)
                <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        wire:click="cancel">
                    {{ __('lara-ui::dialog-confirmation.cancel_button') }}
                </button>
            @else
                <div wire:click="cancel">
                    {!! $closeButton !!}
                </div>
            @endif

            @if(!$confirmButton)
                <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none"
                        wire:click="confirm">
                    {{ __('lara-ui::dialog-confirmation.confirm_button') }}
                </button>
            @else
                <div wire:click="confirm">
                    {!! $confirmButton !!}
                </div>
            @endif
        </div>
    </div>
</div>
