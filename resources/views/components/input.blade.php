@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'shadow-sm border-gray-300 focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50']) !!}>
