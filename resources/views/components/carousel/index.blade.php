@props([
    'pagination' => true,
    'autoPlay' => false,
    'rtl' => false,
    'interval' => 3000,
])

<div x-data="{
    activeSlide: 0,
    totalSlides: 0,
    autoPlay: {{ $autoPlay ? 'true' : 'false' }},
    rtl: {{ $rtl ? 'true' : 'false' }},
    interval: {{ $interval }},
    init() {
        this.totalSlides = this.$el.querySelectorAll('.carousel-slide').length;
        if (this.autoPlay) this.startAutoPlay();
    },
    next() {
        this.activeSlide = this.activeSlide === this.totalSlides - 1 ? 0 : this.activeSlide + 1;
    },
    prev() {
        this.activeSlide = this.activeSlide === 0 ? this.totalSlides - 1 : this.activeSlide - 1;
    },
    startAutoPlay() {
        setInterval(() => this.next(), this.interval);
    }
}" class="relative">
    <div class="relative overflow-hidden w-full min-h-96 bg-white rounded-lg">
        <div class="flex transition-transform duration-700"
             x-bind:style="{ transform: `translateX(-${activeSlide * 100}%)` }">
            {{ $slot }}
        </div>
    </div>

    <button type="button" @click="prev"
            class="absolute inset-y-0 start-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-s-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
            x-bind:class="{ 'opacity-50 pointer-events-none': activeSlide === 0 && !rtl }">
        <span class="text-2xl" aria-hidden="true">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"></path>
            </svg>
        </span>
        <span class="sr-only">Previous</span>
    </button>

    <button type="button" @click="next"
            class="absolute inset-y-0 end-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-e-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
            x-bind:class="{ 'opacity-50 pointer-events-none': activeSlide === totalSlides - 1 && !rtl }">
        <span class="sr-only">Next</span>
        <span class="text-2xl" aria-hidden="true">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"></path>
            </svg>
        </span>
    </button>

    @if($pagination)
        <div class="flex justify-center absolute bottom-3 start-0 end-0 gap-x-2">
            <template x-for="(slide, index) in totalSlides" :key="index">
                <button @click="activeSlide = index"
                        class="size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600"
                        x-bind:class="{ 'bg-blue-700 border-blue-700 dark:bg-blue-500 dark:border-blue-500': activeSlide === index }">
                </button>
            </template>
        </div>
    @endif
</div>
