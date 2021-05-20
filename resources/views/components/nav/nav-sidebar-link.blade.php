@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center space-x-3 p-2 rounded-md font-medium hover:bg-green-400 focus:bg-gray-200 focus:shadow-outline items-center text-sm font-medium leading-5 focus:outline-none bg-green-400 bg-opacity-75 focus:bg-opacity-100 transition duration-150 ease-in-out text-white transition'
            : 'flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 focus:bg-gray-200 focus:shadow-outline items-center text-sm font-medium leading-5 text-gray-900 focus:outline-none bg-gray-200 bg-opacity-0 focus:bg-opacity-100 transition duration-150 ease-in-out transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
