<button
    type="button"
    x-on:click="toggle"
    :aria-controls="id"
    {{ $attributes->merge([
        'class' => 'py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none',
        'aria-haspopup' => 'dialog',
        'aria-expanded' => 'false'
    ]) }}
>
    {{ $slot }}
</button>
