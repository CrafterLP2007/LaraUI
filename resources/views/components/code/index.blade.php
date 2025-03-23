@props([
    'language' => 'blade',
    'content' => '',
    'previewClasses' => '',
    'codeClasses' => '',
    'withCopy' => true,
])

<div x-data="{
        showCode: false
    }">
    <div class="flex items-center justify-between">
        <div class="flex bg-gray-100 rounded-lg p-0.5 dark:bg-neutral-800">
            <nav class="flex gap-x-0.5 md:gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                <button @click="showCode = false" type="button"
                        class="hs-tab-active:bg-white hs-tab-active:text-gray-800 hs-tab-active:shadow-sm hs-tab-active:hover:border-transparent hs-tab-active:focus:border-transparent text-xs md:text-[13px] text-gray-800 border border-transparent hover:border-gray-400 focus:outline-hidden focus:border-gray-400 font-medium rounded-md px-1.5 sm:px-2 py-2 dark:text-neutral-200 dark:hover:text-white dark:hover:border-neutral-500 dark:focus:text-white dark:focus:border-neutral-500 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-neutral-200 dark:hs-tab-active:hover:border-transparent dark:hs-tab-active:focus:border-transparent active"
                        id="types-tab-preview-item" aria-selected="true" data-hs-tab="#types-tab-preview"
                        aria-controls="types-tab-preview" role="tab">
                    Preview
                </button>
                <button @click="showCode = true" type="button"
                        class="hs-tab-active:bg-white hs-tab-active:text-gray-800 hs-tab-active:shadow-sm hs-tab-active:hover:border-transparent hs-tab-active:focus:border-transparent text-xs md:text-[13px] text-gray-800 border border-transparent hover:border-gray-400 focus:outline-hidden focus:border-gray-400 font-medium rounded-md px-1.5 sm:px-2 py-2 dark:text-neutral-200 dark:hover:text-white dark:hover:border-neutral-500 dark:focus:text-white dark:focus:border-neutral-500 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-neutral-200 dark:hs-tab-active:hover:border-transparent dark:hs-tab-active:focus:border-transparent"
                        id="types-tab-html-item" aria-selected="false" data-hs-tab="#types-tab-html"
                        aria-controls="types-tab-html" role="tab">
                    HTML
                </button>
            </nav>
        </div>
    </div>

    <div
        x-show="!showCode" {{ $attributes->merge(['class' => 'bg-neutral-100 dark:bg-neutral-800 rounded-lg p-4 mt-2 border border-gray-200 dark:border-neutral-700 ' . $previewClasses]) }}>
        @if($slot->isNotEmpty())
            {{ $slot }}
        @else
            {!! Blade::render($content) !!}
        @endif
    </div>

    <div
        style="display: none;"
        x-show="showCode" {{ $attributes->merge(['class' => 'bg-black rounded-lg p-4 mt-2 border border-gray-200 dark:border-neutral-700 ' . $codeClasses]) }}>
        <div class="relative">
            @if($withCopy)
                <div class="absolute right-0 top-0">
                    <x-lara-ui::clipboard
                        :text="$content"
                    />
                </div>
            @endif
            <x-torchlight-code
                x-ref="codeContent"
                class="my-6 [&_.line-number]:text-white [&_.line-number]:pr-4"
                style="color: white;"
                :language="$language"
                :contents="$content"
            />
        </div>
    </div>
</div>
