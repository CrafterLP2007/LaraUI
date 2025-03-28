<div>
    <div
        x-data="LaraUIModal()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-show="show"
        class="fixed inset-0 overflow-y-auto"
        style="display: none; z-index: 99999;"
    >
        <!-- Blurred backdrop -->
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500/70 dark:bg-neutral-800/70 backdrop-blur-sm"
            @click="setShowPropertyTo(false)"
        ></div>

        <!-- Modal content container -->
        <div class="min-h-[calc(100%-56px)] flex items-center relative z-20">
            <div
                x-always-open="show && showActiveComponent"
                x-show="show && showActiveComponent"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                id="modal-container"
                x-trap.noscroll.inert="show && showActiveComponent"
                aria-modal="true"
                class="w-full flex flex-col pointer-events-auto sm:max-w-lg sm:w-full m-3 sm:mx-auto bg-white border border-gray-200 shadow-2xs dark:bg-neutral-900 dark:border-neutral-800 rounded-xl"
            >
                @forelse($components as $id => $component)
                    <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}">
                        @livewire($component['name'], $component['arguments'], key($id))
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
