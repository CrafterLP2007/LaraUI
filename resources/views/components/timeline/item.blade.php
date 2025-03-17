<div class="flex gap-x-3">
    <div
        class="relative [&:not(:last-child)]:after:absolute [&:not(:last-child)]:after:top-7 [&:not(:last-child)]:after:bottom-0 [&:not(:last-child)]:after:start-3.5 [&:not(:last-child)]:after:w-px [&:not(:last-child)]:after:-translate-x-[0.5px] [&:not(:last-child)]:after:bg-gray-200 dark:[&:not(:last-child)]:after:bg-neutral-700"
    >
        <div class="relative z-10 size-7 flex justify-center items-center">
            <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
        </div>
    </div>

    <div class="grow pt-0.5 pb-8">
        {{ $slot }}
    </div>
</div>
