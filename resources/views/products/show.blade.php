@extends('layouts.app')

@section('title', $product->title)

@section('content')
    <div class="mb-6 flex items-center justify-between gap-4">
        <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-full border border-slate-200 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
            {{ __('ui.back_to_catalog') }}
        </a>

    </div>

    <article class="glass-panel overflow-hidden rounded-[32px]">
        <div class="grid gap-0 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="space-y-4 p-5 sm:p-7 lg:p-8">
                <p class="inline-flex items-center rounded-full border border-amber-300/40 bg-amber-50 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.35em] text-amber-700">
                    {{ __('ui.product_details') }}
                </p>
                <h1 class="font-['Space_Grotesk'] text-4xl font-bold tracking-tight sm:text-5xl">{{ $product->title }}</h1>
                <p class="max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">{{ $product->description }}</p>
            </div>

            <div class="border-t border-slate-200/70 bg-white/60 p-5 sm:p-7 lg:border-l lg:border-t-0 lg:p-8">
                @if ($product->images->isNotEmpty())
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($product->images as $image)
                            <a href="{{ $image->url }}" target="_blank" class="group overflow-hidden rounded-[24px] bg-slate-100 shadow-lg">
                                <img src="{{ $image->url }}" alt="{{ $product->title }}" class="h-60 w-full object-cover transition duration-500 group-hover:scale-105">
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="relative flex min-h-[320px] items-center justify-center rounded-[24px] border border-dashed border-slate-300 bg-slate-50 text-slate-500">
                        <span class="absolute left-4 top-4 inline-flex items-center rounded-full bg-red-500 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.28em] text-white shadow-lg shadow-red-500/30">
                            {{ __('ui.no_image') }}
                        </span>
                        <div class="flex flex-col items-center justify-center gap-3 px-6 text-center">
                            <div class="rounded-full border border-red-200 bg-red-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-red-600">
                                {{ __('ui.no_images_attached') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </article>
@endsection