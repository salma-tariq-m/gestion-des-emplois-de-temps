@props(['status'])
@if($status)
    <div {{ $attributes->merge(['class' => 'p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium']) }}>
        {{ $status }}
    </div>
@endif
