@props(['active'])

@php
// MODIFIKASI:
// - $active: Mengganti border-indigo-400 ke 600, text-gray-900 ke text-indigo-700, dan menambah font-semibold
// - !$active: Mengganti hover:text-gray-700 ke hover:text-indigo-600 dan hover:border-gray-300 ke hover:border-indigo-300
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-600 text-sm font-semibold leading-5 text-indigo-700 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-indigo-300 focus:outline-none focus:text-indigo-600 focus:border-indigo-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
