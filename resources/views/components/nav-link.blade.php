@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-1 pt-1 pb-1.5 border-b-2 border-blue-600 text-sm font-semibold text-slate-900 focus:outline-none transition-colors duration-150'
    : 'inline-flex items-center px-1 pt-1 pb-1.5 border-b-2 border-transparent text-sm font-medium text-slate-600 hover:text-slate-900 hover:border-slate-300 focus:outline-none transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
