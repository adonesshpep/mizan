<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'Mizan'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|ibm-plex-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen text-slate-950 antialiased dark:text-white">
        <div class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(251,191,36,0.14),transparent_30%),radial-gradient(circle_at_top_right,rgba(59,130,246,0.12),transparent_28%),radial-gradient(circle_at_bottom,rgba(15,23,42,0.08),transparent_28%)]"></div>
            <div class="absolute right-3 top-3 z-10 flex items-center gap-1.5 sm:right-5 sm:top-5">
                <a href="{{ route('locale.switch', 'en') }}" class="rounded-full border border-slate-200 bg-white/80 px-2 py-1.5 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">EN</a>
                <a href="{{ route('locale.switch', 'ar') }}" class="rounded-full border border-slate-200 bg-white/80 px-2 py-1.5 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-700 transition hover:border-slate-300 hover:text-slate-950">AR</a>
            </div>
            <main class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>