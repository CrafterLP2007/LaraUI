
{{-- components/chat/message.blade.php --}}
@props([
    'type' => 'sent',
    'avatar' => null,
    'initials' => null
])

<li @class([
    'flex gap-x-2 sm:gap-x-4',
    'max-w-lg me-11' => $type === 'received',
    'ms-auto' => $type === 'sent'
])>
    @if($type === 'received' && $avatar)
        <img class="inline-block size-9 rounded-full" src="{{ $avatar }}" alt="Avatar">
    @endif

    <div @class([
        'grow' => $type === 'sent',
        'text-end' => $type === 'sent'
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

    @if($type === 'sent' && $initials)
        <span class="shrink-0 inline-flex items-center justify-center size-9.5 rounded-full bg-gray-600">
            <span class="text-sm font-medium text-white">{{ $initials }}</span>
        </span>
    @endif
</li>
