<div>
    <div
        x-data="LaraUIOffCanvas()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-show="show"
        class="fixed inset-0 overflow-y-auto"
        style="display: none; z-index: 99999;"
    >

        <!-- Offcanvas backdrop -->
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

        <!-- Offcanvas panel -->
        <div
            :id="activeComponent"
            x-show="show && showActiveComponent"
            x-transition
            :class="[
                position === 'left' ? 'fixed top-0 start-0 h-full max-w-xs w-full border-e' :
                position === 'right' ? 'fixed top-0 end-0 h-full max-w-xs w-full border-s' :
                position === 'top' ? 'fixed top-0 start-0 h-64 w-full border-b' :
                position === 'bottom' ? 'fixed bottom-0 start-0 h-64 w-full border-t' :
                'fixed bottom-0 start-0 h-64 w-full border-t',
                'z-80 bg-white border-gray-200 dark:bg-neutral-800 dark:border-neutral-700',
                (show && showActiveComponent) ? (
                    position === 'left' ? 'slideInLeft' :
                    position === 'right' ? 'slideInRight' :
                    position === 'top' ? 'slideInDown' :
                    position === 'bottom' ? 'slideInUp' :
                    'slideInLeft'
                ) : (
                    position === 'left' ? 'slideOutLeft' :
                    position === 'right' ? 'slideOutRight' :
                    position === 'top' ? 'slideOutUp' :
                    position === 'bottom' ? 'slideOutDown' :
                    'slideOutLeft'
                )
            ]"
            tabindex="-1"
            :aria-labelledby="`${activeComponent}-label`"
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
