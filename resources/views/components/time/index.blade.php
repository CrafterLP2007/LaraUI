@props([
    'label' => null,
    'hint' => null,
    'showValidation' => true,
    'format24' => true,
])

<div
    x-data="{
        hour: '',
        minute: '',
        ampm: 'am',
        isOpen: false,
        format24: {{ $format24 ? 'true' : 'false' }},
        formattedTime: '',

        setCurrentTime() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes();

            if (this.format24) {
                this.hour = hours.toString().padStart(2, '0');
            } else {
                this.ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                this.hour = (hours === 0 ? 12 : hours).toString().padStart(2, '0');
            }

            this.minute = minutes.toString().padStart(2, '0');
            this.updateFormattedTime();
            this.isOpen = false;
        },

        updateFormattedTime() {
            if (this.hour && this.minute) {
                this.formattedTime = this.format24
                    ? `${this.hour}:${this.minute}`
                    : `${this.hour}:${this.minute} ${this.ampm}`;
            }
        },

        init() {
            this.$watch('hour', () => this.updateFormattedTime());
            this.$watch('minute', () => this.updateFormattedTime());
            this.$watch('ampm', () => this.updateFormattedTime());
        }
    }"
    class="max-w-32"
>
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <label class="block text-sm dark:text-white">{{ $label }}</label>
        </div>
    @endif

    <div class="relative w-full">
        <input
            type="text"
            x-model="formattedTime"
            x-on:click="isOpen = true"
            {{ $attributes->twMerge('py-2.5 sm:py-3 ps-4 pe-12 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-400 dark:focus:ring-neutral-600') }}
            placeholder="{{ $format24 ? 'HH:mm' : 'hh:mm am' }}"
            readonly
        >

        <div class="absolute inset-y-0 end-0 flex items-center pe-3">
            <div class="relative">
                <button
                    x-ref="trigger"
                    type="button"
                    x-on:click="isOpen = !isOpen"
                    class="size-7 shrink-0 inline-flex justify-center items-center rounded-full bg-white text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    aria-expanded="false"
                    aria-label="Time picker"
                >
                    <span class="sr-only">Select time</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </button>

                <div
                    x-show="isOpen"
                    x-on:click.away="isOpen = false"
                    x-anchor.bottom-start.offset.4="$refs.trigger"
                    x-transition
                    class="absolute z-50 w-fit bg-white border border-gray-200 shadow-xl rounded-lg dark:bg-neutral-800 dark:border-neutral-700 dark:divide-neutral-700"
                    style="display: none;"
                >
                    <div class="flex flex-row divide-x divide-gray-200 dark:divide-neutral-700">
                        <!-- Hours -->
                        <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                            @foreach(range(0, $format24 ? 23 : 12) as $h)
                                @if(!$format24 && $h === 0)
                                    @continue
                                @endif
                                <label
                                    for="hour-{{ $h }}"
                                    class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200"
                                    :class="{ 'bg-blue-600 text-white': hour === '{{ sprintf('%02d', $h) }}' }"
                                >
                                    <input type="radio" id="hour-{{ $h }}" name="hour" value="{{ sprintf('%02d', $h) }}" x-model="hour" class="sr-only">
                                    <span class="block">{{ sprintf('%02d', $h) }}</span>
                                </label>
                            @endforeach
                        </div>

                        <!-- Minutes -->
                        <div class="p-1 max-h-56 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-800 dark:hover:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                            @foreach(range(0, 59) as $m)
                                <label
                                    for="minute-{{ $m }}"
                                    class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200"
                                    :class="{ 'bg-blue-600 text-white': minute === '{{ sprintf('%02d', $m) }}' }"
                                >
                                    <input type="radio" id="minute-{{ $m }}" name="minute" value="{{ sprintf('%02d', $m) }}" x-model="minute" class="sr-only">
                                    <span class="block">{{ sprintf('%02d', $m) }}</span>
                                </label>
                            @endforeach
                        </div>

                        @unless($format24)
                            <!-- AM/PM -->
                            <div class="p-1">
                                <label
                                    for="ampm-am"
                                    class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200"
                                    :class="{ 'bg-blue-600 text-white': ampm === 'am' }"
                                >
                                    <input type="radio" id="ampm-am" name="ampm" value="am" x-model="ampm" class="sr-only">
                                    <span class="block">{{ __('lara-ui::time.am') }}</span>
                                </label>

                                <label
                                    for="ampm-pm"
                                    class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100 hover:text-gray-800 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:hover:text-neutral-200"
                                    :class="{ 'bg-blue-600 text-white': ampm === 'pm' }"
                                >
                                    <input type="radio" id="ampm-pm" name="ampm" value="pm" x-model="ampm" class="sr-only">
                                    <span class="block">{{ __('lara-ui::time.pm') }}</span>
                                </label>
                            </div>
                        @endunless
                    </div>

                    <!-- Now button -->
                    <div class="py-2 px-3 border-t border-gray-200 dark:border-neutral-700">
                        <button
                            type="button"
                            x-on:click="setCurrentTime()"
                            class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700"
                        >
                            {{ __('lara-ui::time.now_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" x-model="formattedTime" {{ $attributes->only(['wire:model', 'wire:model.live', 'wire:model.blur', 'wire:model.defer', 'name']) }} />

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>
