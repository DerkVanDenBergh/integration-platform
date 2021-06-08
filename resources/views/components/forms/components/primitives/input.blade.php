@props(['disabled' => false])

<input {{ ($required ?? false) ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 disabled:bg-gray-600']) !!}>
