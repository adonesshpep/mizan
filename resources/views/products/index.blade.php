@extends('layouts.app')

@section('title', 'Catalog')

@section('content')
    <section class="mb-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="max-w-3xl space-y-5">
                <p class="brand-chip inline-flex items-center rounded-full border px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.35em] shadow-sm">
                {{ __('ui.product_showcase') }}
            </p>
            <div class="space-y-4">
                <h1 class="font-['Space_Grotesk'] text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                    {{ __('ui.catalog_heading') }}
                </h1>
                <p class="max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">
                    {{ __('ui.catalog_description') }}
                </p>
            </div>
        </div>

    </section>

    <section class="glass-panel mb-8 rounded-[32px] p-4 sm:p-6" data-catalog-root data-next-page-url="{{ $products->nextPageUrl() ?? '' }}">
        <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-col gap-3 md:flex-row">
            <div class="flex-1">
                <label for="search" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.search_products') }}</label>
                <input id="search" name="search" value="{{ $search }}" placeholder="{{ __('ui.search_placeholder') }}" class="brand-field w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="brand-button rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    {{ __('ui.search') }}
                </button>
                @if ($search !== '')
                    <a href="{{ route('products.index') }}" class="brand-button-soft rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900">
                        {{ __('ui.clear') }}
                    </a>
                @endif
            </div>
        </form>

        <div class="grid catalog-grid gap-5 sm:gap-6" data-products-grid>
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group overflow-hidden rounded-[28px] border border-white/70 bg-white shadow-[0_24px_70px_rgba(15,23,42,0.12)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_34px_80px_rgba(15,23,42,0.18)]">
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                        @if ($product->images->first())
                            <img src="{{ $product->images->first()->url }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
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
                            <h2 class="text-lg font-semibold text-slate-950">{{ $product->title }}</h2>
                            <span class="brand-chip rounded-full border px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.3em]">{{ __('ui.view') }}</span>
                        </div>
                        <p class="line-clamp-3 text-sm leading-6 text-slate-600">{{ $product->description }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full rounded-[28px] border border-dashed border-slate-300 bg-white/70 p-10 text-center text-slate-500">
                    {{ __('ui.no_products_found') }}
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex items-center justify-center">
            <div data-load-more class="h-10 w-10 rounded-full border-4 border-slate-200 border-t-[var(--brand-orange)]"></div>
        </div>
        <p data-feed-status class="mt-4 text-center text-sm text-slate-500">
            {{ __('ui.scroll_to_load_more') }}
        </p>
    </section>
@endsection