@props(['title', 'description' => null])

<h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
    {{ $title }}
</h3>

@if($description)
    <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
        {{ $description }}
    </p>
@endif

{{ $slot }}
