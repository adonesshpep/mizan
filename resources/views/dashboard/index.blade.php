@extends('layouts.app')

@section('title', __('ui.admin_dashboard'))

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="brand-chip inline-flex items-center rounded-full border px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.35em]">
                {{ __('ui.admin_dashboard') }}
            </p>
            <h1 class="mt-4 font-['Space_Grotesk'] text-4xl font-bold tracking-tight text-slate-950">{{ __('ui.manage_products') }}</h1>
        </div>

        <form method="POST" action="{{ route('dashboard.logout') }}">
            @csrf
            <button type="submit" class="brand-button-soft rounded-full border border-slate-200 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                {{ __('ui.log_out') }}
            </button>
        </form>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    <section class="glass-panel mb-8 rounded-[32px] p-6 sm:p-8">
        <h2 class="font-['Space_Grotesk'] text-2xl font-semibold text-slate-950">{{ __('ui.create_product') }}</h2>
        <form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data" class="mt-6 grid gap-5">
            @csrf
            <div class="grid gap-5 lg:grid-cols-3">
                <div>
                    <label for="title" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.title') }}</label>
                    <input id="title" name="title" value="{{ old('title') }}" required class="brand-field w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
                    @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="position" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.priority') }}</label>
                    <input id="position" name="position" type="number" min="0" value="{{ old('position', 0) }}" required class="brand-field w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
                    <p class="mt-2 text-xs text-slate-500">{{ __('ui.priority_help') }}</p>
                    @error('position')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="images" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.images') }}</label>
                    <input id="images" name="images[]" type="file" multiple accept="image/*" required class="brand-field w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-[var(--brand-ink)] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
                    @error('images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.description') }}</label>
                <textarea id="description" name="description" rows="6" required class="brand-field w-full rounded-[24px] border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">{{ old('description') }}</textarea>
                @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <button type="submit" class="brand-button rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    {{ __('ui.save_product') }}
                </button>
            </div>
        </form>
    </section>

    <section class="space-y-5">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-['Space_Grotesk'] text-2xl font-semibold text-slate-950">{{ __('ui.latest_products') }}</h2>
            <a href="{{ route('products.index') }}" class="brand-link text-sm font-semibold text-slate-600 transition hover:text-slate-950">{{ __('ui.view_public_catalog') }}</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($products as $product)
                <article class="overflow-hidden rounded-[28px] border border-white/70 bg-white shadow-[0_24px_70px_rgba(15,23,42,0.12)]">
                    <div class="relative aspect-[4/3] bg-slate-100">
                        @if ($product->images->first())
                            <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="relative flex h-full items-center justify-center bg-gradient-to-br from-red-50 via-amber-50 to-slate-200 text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">
                                <span class="absolute left-3 top-3 inline-flex items-center rounded-full bg-red-500 px-2 py-1 text-[9px] font-bold uppercase tracking-[0.22em] text-white shadow-lg shadow-red-500/30">
                                    {{ __('ui.no_image') }}
                                </span>
                                <div class="mt-8 flex items-center justify-center rounded-full border border-white/70 bg-white/80 px-3 py-1.5 text-[9px] font-semibold uppercase tracking-[0.2em] text-slate-700 shadow-sm">
                                    {{ __('ui.view') }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-3 p-5">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="text-lg font-semibold text-slate-950">{{ $product->title }}</h3>
                            <span class="brand-chip rounded-full border px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.3em]">{{ __('ui.priority') }} {{ $product->position }}</span>
                        </div>
                        <p class="line-clamp-3 text-sm leading-6 text-slate-600">{{ $product->description }}</p>
                        <div class="flex flex-wrap gap-2 pt-2">
                            <a href="{{ route('products.show', $product) }}" class="brand-button-soft rounded-full border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
                                {{ __('ui.view') }}
                            </a>
                            <a href="{{ route('dashboard.products.edit', $product) }}" class="brand-button-soft rounded-full border border-amber-300/60 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:border-amber-400 hover:text-amber-800">
                                {{ __('ui.edit') }}
                            </a>
                            <form method="POST" action="{{ route('dashboard.products.destroy', $product) }}" onsubmit="return confirm('{{ __('ui.confirm_delete_product') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="brand-button-soft rounded-full border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:text-red-700">
                                    {{ __('ui.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[28px] border border-dashed border-slate-300 bg-white/70 p-8 text-slate-500">
                    {{ __('ui.no_products_yet') }}
                </div>
            @endforelse
        </div>
    </section>
@endsection