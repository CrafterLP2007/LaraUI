@props([
    'target',
    'action' => 'open'
])

<button
    type="button"
    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
    aria-haspopup="dialog"
    aria-expanded="false"
    aria-controls="{{ $target }}"

    @if($action === 'open')
        data-hs-overlay="#{{ $target }}"
    @elseif($action === 'close')
        data-hs-overlay-close="#{{ $target }}"
    @else
        @php throw new Exception("Action " . $action . " not available") @endphp
    @endif
>
    {{ $slot }}
</button>
