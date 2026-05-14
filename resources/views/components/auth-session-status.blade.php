@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700 dark:border-green-500/30 dark:bg-green-500/10 dark:text-green-200']) }}>
        {{ $status }}
    </div>
@endif
