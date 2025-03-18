<div
    class="fixed top-4 right-4 z-50 flex flex-col gap-y-2 w-96 pointer-events-none"
>
    @foreach($notifications as $notification)
        <div wire:key="notification-{{ $notification->getId() }}">
            <x-lara-ui::alert
                :variant="$notification->variant"
                :color="$notification->color"
            >
                <div>
                    <div class="font-medium">
                        {{ $notification->title }}
                    </div>
                    @if($notification->message)
                        <div>{{ $notification->message }}</div>
                    @endif
                </div>

                @if($notification->dismissable)
                    <button
                        type="button"
                        class="inline-flex bg-teal-50 rounded-lg p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-hidden focus:bg-teal-100 dark:bg-transparent dark:text-teal-600 dark:hover:bg-teal-800/50 dark:focus:bg-teal-800/50 ml-3 shrink-0"
                        wire:click="$dispatch('notification-close', { id: '{{ $notification->getId() }}' })"
                    >
                        <span class="sr-only">Dismiss</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                @endif
            </x-lara-ui::alert>
        </div>
    @endforeach
</div>
