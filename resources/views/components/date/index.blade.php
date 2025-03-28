@props([
    'label' => null,
    'cornerHint' => null,
    'hint' => null,
    'showCurrentDate' => false,
    'locale' => 'de-DE',
    'format' => 'dd.MM.yyyy',
    'closeOnSelect' => false
])

@if($label)
    <div class="flex justify-between items-center mb-2">
        <label class="block text-sm font-medium dark:text-white">
            {{ $label }}
        </label>
        @if($cornerHint)
            <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $cornerHint }}</span>
        @endif
    </div>
@endif

<div
    x-data="{
        showDatepicker: false,
        dateValue: null,
        month: '',
        year: '',
        days: [],
        blankdays: [],
        modelValue: @entangle($attributes->wire('model')),
        format: '{{ $format }}',
        closeOnSelect: {{ $closeOnSelect ? 'true' : 'false' }},
        showCurrentDate: {{ $showCurrentDate ? 'true' : 'false' }},
        weekDays: {{ json_encode([
            __('lara-ui::date.weeks.monday'),
            __('lara-ui::date.weeks.tuesday'),
            __('lara-ui::date.weeks.wednesday'),
            __('lara-ui::date.weeks.thursday'),
            __('lara-ui::date.weeks.friday'),
            __('lara-ui::date.weeks.saturday'),
            __('lara-ui::date.weeks.sunday')
        ]) }},
        monthNames: {{ json_encode([
            __('lara-ui::date.months.january'),
            __('lara-ui::date.months.february'),
            __('lara-ui::date.months.march'),
            __('lara-ui::date.months.april'),
            __('lara-ui::date.months.may'),
            __('lara-ui::date.months.june'),
            __('lara-ui::date.months.july'),
            __('lara-ui::date.months.august'),
            __('lara-ui::date.months.september'),
            __('lara-ui::date.months.october'),
            __('lara-ui::date.months.november'),
            __('lara-ui::date.months.december')
        ]) }},

        init() {
            try {
                const today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();

                // Check if we have an initial value from Livewire
                if (this.modelValue) {
                    const value = String(this.modelValue); // Ensure it's a string
                    if (value && value.includes('-')) {
                        const parts = value.split('-');
                        if (parts.length === 3) {
                            const [y, m, d] = parts.map(Number);
                            const date = new Date(y, m - 1, d);

                            if (this.isValidDate(date)) {
                                this.dateValue = date;
                                this.month = date.getMonth();
                                this.year = date.getFullYear();
                            }
                        }
                    }
                }

                this.calculateDays();

                // Watch for model changes
                this.$watch('modelValue', value => {
                    if (value && value.includes('-')) {
                        const parts = value.split('-');
                        if (parts.length === 3) {
                            const [y, m, d] = parts.map(Number);
                            const date = new Date(y, m - 1, d);
                            if (this.isValidDate(date)) {
                                this.dateValue = date;
                            }
                        }
                    } else {
                        this.dateValue = null;
                    }
                });
            } catch (e) {
                console.error('Date initialization error:', e);
                const today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.calculateDays();
            }
        },

        calculateDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
            let firstDayOfMonth = new Date(this.year, this.month, 1);
            let firstDayWeekday = firstDayOfMonth.getDay() || 7;

            this.blankdays = Array(firstDayWeekday - 1).fill(null);
            this.days = Array.from({length: daysInMonth}, (_, i) => i + 1);
        },

        isSelectedDate(date) {
            if (!this.dateValue) return false;
            return date === this.dateValue.getDate() &&
                this.month === this.dateValue.getMonth() &&
                this.year === this.dateValue.getFullYear();
        },

        isToday(date) {
            const today = new Date();
            return date === today.getDate() &&
                this.month === today.getMonth() &&
                this.year === today.getFullYear();
        },

        formatDate(date) {
            if (!date) return '';

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();

            return this.format
                .replace('dd', day)
                .replace('MM', month)
                .replace('yyyy', year)
                .replace('yy', year.toString().slice(-2));
        },

        get formattedDate() {
            return this.dateValue ? this.formatDate(this.dateValue) : '';
        },

        togglePicker() {
            this.showDatepicker = !this.showDatepicker;
        },

        selectDate(date) {
            try {
                const newDate = new Date(this.year, this.month, date);
                this.dateValue = newDate;

                // Update the wire model
                const year = newDate.getFullYear();
                const month = String(newDate.getMonth() + 1).padStart(2, '0');
                const day = String(newDate.getDate()).padStart(2, '0');
                this.modelValue = `${year}-${month}-${day}`;

                if (this.closeOnSelect) {
                    this.showDatepicker = false;
                }
            } catch (e) {
                console.error('Date selection error:', e);
            }
        },

        isValidDate(date) {
            return date instanceof Date && !isNaN(date.getTime());
        },

        previousMonth() {
            if (this.month === 0) {
                this.year--;
                this.month = 11;
            } else {
                this.month--;
            }
            this.calculateDays();
        },

        nextMonth() {
            if (this.month === 11) {
                this.year++;
                this.month = 0;
            } else {
                this.month++;
            }
            this.calculateDays();
        }
    }"
    class="relative"
    wire:ignore.self
>
    <input
        type="text"
        x-model="formattedDate"
        x-ref="input"
        @click="togglePicker"
        @keydown.escape="showDatepicker = false"
        role="textbox"
        aria-readonly="true"
        {{ $attributes->class([
            'py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-600 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder:text-neutral-400 dark:focus:border-blue-500 dark:focus:ring-neutral-500 cursor-pointer'
        ])->whereDoesntStartWith('wire:model') }}
        readonly
    >

    <div
        x-show="showDatepicker"
        x-transition
        @click.away="showDatepicker = false"
        class="absolute top-full left-0 z-50 mt-2 p-4 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-900 dark:border-neutral-700"
        style="display: none;"
    >
        <div class="flex items-center justify-between mb-2">
            <button
                type="button"
                class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                @click.prevent.stop="previousMonth"
            >
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
            </button>
            <div class="text-sm font-medium text-gray-800 dark:text-neutral-200"
                 x-text="monthNames[month] + ' ' + year"></div>
            <button
                type="button"
                class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                @click.prevent.stop="nextMonth"
            >
                <svg class="shrink-0 size-4" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </button>
        </div>

        <div class="vc-dates grid grid-cols-7 gap-y-0.5">
            <template x-for="day in weekDays" :key="day">
                <div
                    class="m-px w-10 block font-normal text-center text-sm text-gray-500 focus:outline-hidden dark:text-neutral-500"
                    x-text="day"></div>
            </template>

            <template x-for="(blankday, index) in blankdays" :key="'blank-' + index">
                <div class="size-10.5"></div>
            </template>

            <template x-for="(date, dateIndex) in days" :key="'current-' + dateIndex">
                <div
                    @click.prevent.stop="selectDate(date)"
                    x-text="date"
                    class="vc-date relative size-10.5 flex justify-center items-center text-sm rounded-full cursor-pointer"
                    :class="{
            'text-white bg-blue-600 hover:bg-blue-700 hover:text-white dark:bg-blue-500 dark:hover:bg-blue-600': isSelectedDate(date),
            'text-gray-800 hover:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-800': !isSelectedDate(date),
            'bg-blue-500 text-white hover:text-white dark:bg-blue-600': showCurrentDate && isToday(date) && !isSelectedDate(date)
        }"
                ></div>
            </template>
        </div>
    </div>
</div>

@if($hint)
    <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $hint }}</p>
@endif

@if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
    <div
        class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
@endif
