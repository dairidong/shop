@props([
    'status',
    'type' => 'info'
])

@php
    $base_class = 'p-4 ';
    switch ($type) {
    case 'primary':
        $class = $base_class . 'text-blue-800 bg-blue-100';
        break;
    case 'danger':
        $class = $base_class . 'text-white bg-active';
        break;
    case 'success':
        $class = $base_class . 'text-green-800 bg-green-200';
        break;
    case 'warning':
        $class = $base_class . 'text-yellow-800 bg-yellow-100';
        break;
    case 'info':
    default:
        $class = $base_class . 'text-gray-800 bg-white';
        break;
    }
@endphp

@if ($status)
    <div {{ $attributes->merge([
        'class' => $class,
        'role' => 'alert',
    ]) }}>
        {{ $status }}
    </div>
@endif
