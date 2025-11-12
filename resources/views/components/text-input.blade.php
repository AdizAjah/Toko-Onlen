@props(['disabled' => false])

<!-- 
    MODIFIKASI:
    - Mengganti warna focus ring default (focus:ring-indigo-200, focus:border-indigo-900, dll)
    - Menjadi 'focus:border-indigo-500' dan 'focus:ring-indigo-500'
    - Ini akan membuat input field serasi dengan tombol Indigo saat di-klik (fokus)
-->
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
    ]) !!}>
