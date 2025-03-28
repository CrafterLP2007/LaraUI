@props([
    'target',
    'action' => 'open'
])

@php
    $validActions = ['open', 'close'];
    if (!in_array($action, $validActions)) {
        throw new Exception("Invalid action '{$action}'. Allowed values are: " . implode(', ', $validActions));
    }

    if (empty($target)) {
        throw new Exception("The target attribute is required");
    }

    $dataAttribute = $action === 'close' ? 'data-hs-overlay-close' : 'data-hs-overlay';
@endphp

<div
    {{ $attributes->merge([
        $dataAttribute => "#{$target}",
        'class' => 'inline-block'
    ]) }}
    role="button"
    aria-haspopup="dialog"
    aria-expanded="false"
    aria-controls="{{ $target }}"
>
    {{ $slot }}
</div>
