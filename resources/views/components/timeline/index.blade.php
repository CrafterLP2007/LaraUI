@props(['date' => now()])

<div>
    @isset($date)
        <div class="ps-2 my-2 first:mt-0">
            <h3 class="text-xs font-medium uppercase text-gray-500 dark:text-neutral-400">
                {{ $date }}
            </h3>
        </div>
    @endisset

    {{ $slot }}
</div>
