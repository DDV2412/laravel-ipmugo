@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 shadow-md pt-1 text-sm font-bold leading-5 text-white focus:outline-none  transition uppercase bg-blue-500'
            : 'inline-flex items-center px-4 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:bg-blue-500 focus:outline-none focus:text-gray-700 hover:text-white focus:border-gray-300 transition uppercase';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
