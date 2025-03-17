{{-- components/chat/avatar.blade.php --}}
@props(['src'])

<img
    {{ $attributes->twMerge('size-8 rounded-full object-cover') }}
    src="{{ $src }}"
    alt="avatar"
>
