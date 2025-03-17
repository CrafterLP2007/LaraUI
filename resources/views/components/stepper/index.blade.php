{{-- index.blade.php --}}
@props([
    'uuid' => 'lara-ui-stepper-' . Str::random(8),
    'currentStep' => 1,
])

<div {{ $attributes->merge(['class' => 'p-4 bg-white rounded-lg shadow-md dark:bg-neutral-800']) }}
     x-data="{
        step: {{ $attributes->wire('model')->value() ? '$wire.' . $attributes->wire('model')->value() : $currentStep }},
        totalSteps: 0,
        init() {
            this.totalSteps = this.$el.querySelectorAll('[data-step-index]').length;
            const modelName = '{{ $attributes->wire('model')->value() }}';

            if (modelName) {
                $wire.$watch(modelName, value => {
                    this.step = value;
                    this.showCurrentStep();
                });
            }
        },
        next() {
            if (this.step < this.totalSteps) {
                this.step++;
                $wire.set('{{ $attributes->wire('model')->value() }}', this.step);
                this.showCurrentStep();
            }
        },
        previous() {
            if (this.step > 1) {
                this.step--;
                $wire.set('{{ $attributes->wire('model')->value() }}', this.step);
                this.showCurrentStep();
            }
        },
        goToStep(step) {
            if (step >= 1 && step <= this.totalSteps) {
                this.step = step;
                $wire.set('{{ $attributes->wire('model')->value() }}', this.step);
                this.showCurrentStep();
            }
        },
        showCurrentStep() {
            this.$el.querySelectorAll('[data-step-content]').forEach(content => {
                content.style.display = content.getAttribute('data-step-content') == this.step ? 'block' : 'none';
            });
        }
     }">
    <div class="stepper-{{ $uuid }}">
        <ul class="relative flex flex-row gap-x-2 mb-4">
            {{ $slot }}
        </ul>
    </div>
</div>
