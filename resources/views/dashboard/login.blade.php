@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="flex flex-1 items-center justify-center py-12">
        <section class="glass-panel w-full max-w-md rounded-[32px] p-8">
            <p class="mb-3 inline-flex items-center rounded-full border border-amber-300/40 bg-amber-50 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.35em] text-amber-700">
                {{ __('ui.dashboard_access') }}
            </p>
            <h1 class="font-['Space_Grotesk'] text-3xl font-bold tracking-tight text-slate-950">{{ __('ui.admin_password_heading') }}</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('ui.admin_password_description') }}</p>

            @if ($errors->any())
                <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <form method="POST" action="{{ route('dashboard.login') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="password" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.password') }}</label>
                    <input id="password" name="password" type="password" required autofocus class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
                </div>

                <button type="submit" class="w-full rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    {{ __('ui.open_dashboard') }}
                </button>
            </form>
        </section>
    </div>
@endsection