@props([
    'type' => 'sent',
])

<li {{ $attributes->twMerge('flex gap-x-2 sm:gap-x-4 ' . ($type === 'received' ? 'max-w-lg me-11' : 'ms-auto')) }}>
    @if($type === 'received' && isset($avatar))
        {{ $avatar }}
    @endif

    <div @class([
        'grow flex flex-col' => $type === 'sent',
        'grow' => $type === 'received',
        'items-end' => $type === 'sent',
    ])>
        <div @class([
            'inline-block',
            'bg-white border border-gray-200 rounded-2xl p-4 space-y-3 dark:bg-neutral-900 dark:border-neutral-700' => $type === 'received',
            'bg-blue-600 rounded-2xl p-4 shadow-2xs' => $type === 'sent'
        ])>
            <div @class([
                'text-sm',
                'text-gray-800 dark:text-white' => $type === 'received',
                'text-white' => $type === 'sent'
            ])>
                {{ $slot }}
            </div>
        </div>

        @if($footer ?? false)
            {{ $footer }}
        @endif
    </div>

    @if($type === 'sent' && isset($avatar))
        {{ $avatar }}
    @endif
</li>
