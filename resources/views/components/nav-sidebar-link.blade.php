@props(['active'])

@php
$classes = ($active ?? false)
            ? 'items-center text-sm font-medium leading-5 text-gray-900 focus:outline-none bg-gray-200 bg-opacity-75 focus:bg-opacity-100 transition duration-150 ease-in-out'
            : 'items-center text-sm font-medium leading-5 text-gray-900 focus:outline-none bg-gray-200 bg-opacity-0 focus:bg-opacity-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
