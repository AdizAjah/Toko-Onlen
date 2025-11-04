@props(['active'])

@php
// MODIFIKASI:
// - $active: Mengganti border-indigo-400 ke 600, bg-indigo-50 ke 100, dan menambah font-semibold
// - !$active: Mengganti hover:text-gray-800 ke hover:text-indigo-700, hover:bg-gray-50 ke hover:bg-indigo-50, dll.
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-600 text-start text-base font-semibold text-indigo-700 bg-indigo-100 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-indigo-700 hover:bg-indigo-50 hover:border-indigo-300 focus:outline-none focus:text-indigo-700 focus:bg-indigo-50 focus:border-indigo-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
