@props(['name'])

@switch($name)
    @case('dashboard')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.75 5.75h6.5v6.5h-6.5zm8 0h6.5v4.5h-6.5zm0 6h6.5v6.5h-6.5zm-8 8h6.5v-4.5h-6.5z" />
        </svg>
        @break

    @case('layers')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m12 4.75 7 3.75-7 3.75-7-3.75zm-7 7.25 7 3.75 7-3.75M5 15.5l7 3.75 7-3.75" />
        </svg>
        @break

    @case('wallet')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.75 8.25A2.5 2.5 0 0 1 7.25 5.75h9.5a2.5 2.5 0 0 1 2.5 2.5v.75h-9.5a2.5 2.5 0 0 0 0 5h9.5v1.75a2.5 2.5 0 0 1-2.5 2.5h-9.5a2.5 2.5 0 0 1-2.5-2.5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.25 10.25h-9.5a1.75 1.75 0 0 0 0 3.5h9.5z" />
            <circle cx="10.75" cy="12" r=".75" fill="currentColor" stroke="none" />
        </svg>
        @break

    @case('users')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.25 18.25v-.75a3.5 3.5 0 0 0-3.5-3.5h-3a3.5 3.5 0 0 0-3.5 3.5v.75" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.25 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6 1.25a2.5 2.5 0 1 0 0-5m2.5 11v-.5a3 3 0 0 0-2.25-2.9" />
        </svg>
        @break

    @case('transactions')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7.25h10.25m-7.5 4.75H17m-10 4.75h10.25" />
            <path stroke-linecap="round" stroke-linejoin="round" d="m13.5 5.5 3.75 1.75-3.75 1.75M10.5 18.5 6.75 16.75 10.5 15" />
        </svg>
        @break

    @case('document-text')
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
        @break

    @default
        <svg {{ $attributes->merge(['class' => 'h-5 w-5']) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <circle cx="12" cy="12" r="7" />
        </svg>
@endswitch
