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
            <header class="relative z-10 mx-auto flex w-full max-w-7xl items-start justify-between gap-4 px-4 pt-14 sm:px-6 lg:px-8 lg:pt-16">
                <a href="{{ route('products.index') }}" class="flex h-16 w-16 items-center justify-center rounded-[1.25rem] border border-white/70 bg-white/75 shadow-[0_18px_45px_rgba(52,73,90,0.12)] backdrop-blur transition duration-200 hover:-translate-y-0.5">
                    <img src="{{ asset('storage/icons/main.jpg') }}" alt="Najjar Group main icon" class="h-full w-full object-contain p-2">
                </a>

                <div class="flex items-start gap-3">
                    <div class="flex h-16 w-16 items-center justify-center rounded-[1.25rem] border border-white/70 bg-white/75 shadow-[0_18px_45px_rgba(52,73,90,0.12)] backdrop-blur transition duration-200 hover:-translate-y-0.5">
                        <img src="{{ asset('storage/icons/second.jpg') }}" alt="Najjar Group secondary icon" class="h-full w-full object-contain p-2">
                    </div>
                </div>
                <div class="absolute end-3 top-2 flex items-center gap-1 sm:end-4 sm:top-3 lg:end-5 lg:top-3">
                    <a href="{{ route('locale.switch', 'en') }}" class="rounded-full border border-slate-200 bg-white/85 px-2 py-1 text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-700 shadow-sm transition hover:border-slate-300 hover:text-slate-950">EN</a>
                    <a href="{{ route('locale.switch', 'ar') }}" class="rounded-full border border-slate-200 bg-white/85 px-2 py-1 text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-700 shadow-sm transition hover:border-slate-300 hover:text-slate-950">AR</a>
                </div>
            </header>
            <main class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8 lg:pt-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>