@props([
    'label' => null,
    'variant' => 'default',
    'placeholder' => '⚬',
    'length' => 4,
    'type' => 'text',
    'size' => 'default',
    'hint' => null,
    'cornerHint' => null,
    'showValidation' => true,
])

@php
    if (!$length > 1) {
        throw new Exception('Length must be greater than 1');
    }
@endphp

@inject('pinService', 'CrafterLP2007\LaraUi\Services\LaraUI\PinCvaService')

<div x-data="{
    pins: Array({{ $length }}).fill(''),
    focusNext(index) {
        if (index < {{ $length }} - 1 && this.pins[index].length === 1) {
            this.$nextTick(() => {
                this.$refs[`pin-${index + 1}`].focus();
            });
        }
    },
    handleBackspace(index, event) {
        if (this.pins[index].length === 0 && index > 0) {
            // Field is empty and backspace was pressed, move to previous field and clear it
            this.pins[index-1] = '';
            this.$nextTick(() => {
                this.$refs[`pin-${index - 1}`].focus();
            });
        }
    },
    getPinValue() {
        return this.pins.join('');
    },
    handleInput() {
        @if($attributes->whereStartsWith('wire:model')->first())
            $wire.set('{{ $attributes->whereStartsWith('wire:model')->first() }}', this.getPinValue());
        @endif
    }
}"
     x-init="
    @if($attributes->whereStartsWith('wire:model')->first())
        $watch('pins', () => handleInput());
    @endif
"
     class="relative">
    @if($label)
        <div class="flex justify-between items-center mb-2">
            <label class="block text-sm dark:text-white">{{ $label }}</label>
            @if($cornerHint)
                <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $cornerHint }}</span>
            @endif
        </div>
    @endif

    <div class="flex gap-x-3">
        @foreach(range(0, $length - 1) as $index)
            <input
                type="{{ $type }}"
                x-ref="pin-{{ $index }}"
                x-model="pins[{{ $index }}]"
                @input="focusNext({{ $index }})"
                @keydown.backspace="handleBackspace({{ $index }}, $event)"
                @focus="$event.target.select()"
                {{ $attributes->except(['wire:model', 'wire:model.live', 'wire:model.blur', 'wire:model.defer'])->twMerge($pinService::new()(['variant' => $variant, 'size' => $size])) }}
                placeholder="{{ $placeholder }}"
                maxlength="1">
        @endforeach
    </div>

    <input type="hidden" x-model="getPinValue()" {{ $attributes->only(['wire:model', 'wire:model.live', 'wire:model.blur', 'wire:model.defer']) }} />

    @if($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">{{ $hint }}</p>
    @endif

    @if($attributes->whereStartsWith('wire:model')->first() && $errors->has($attributes->whereStartsWith('wire:model')->first()) && $showValidation)
        <div class="text-red-600 text-sm">{{ $errors->first($attributes->whereStartsWith('wire:model')->first()) }}</div>
    @endif
</div>
