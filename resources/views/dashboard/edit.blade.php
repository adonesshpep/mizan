@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="mb-6 flex items-center justify-between gap-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-full border border-slate-200 bg-white/70 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-950">
            {{ __('ui.back_to_dashboard') }}
        </a>

        <a href="{{ route('products.show', $product) }}" class="inline-flex items-center rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
            {{ __('ui.view_product') }}
        </a>
    </div>

    <section class="glass-panel rounded-[32px] p-6 sm:p-8">
        <div class="mb-6 space-y-2">
            <p class="inline-flex items-center rounded-full border border-amber-300/40 bg-amber-50 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.35em] text-amber-700">
                {{ __('ui.edit_product') }}
            </p>
            <h1 class="font-['Space_Grotesk'] text-3xl font-bold tracking-tight text-slate-950">{{ $product->title }}</h1>
            <p class="text-sm text-slate-600">{{ __('ui.lower_priority_hint') }}</p>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.products.update', $product) }}" enctype="multipart/form-data" class="grid gap-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 lg:grid-cols-3">
                <div>
                    <label for="title" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.title') }}</label>
                    <input id="title" name="title" value="{{ old('title', $product->title) }}" required class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
                    @error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="position" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.priority') }}</label>
                    <input id="position" name="position" type="number" min="0" value="{{ old('position', $product->position) }}" required class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
                    @error('position')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="images" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.add_images') }}</label>
                    <input id="images" name="images[]" type="file" multiple accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">
                    <p class="mt-2 text-xs text-slate-500">{{ __('ui.optional_add_images') }}</p>
                    @error('images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-2 block text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.description') }}</label>
                <textarea id="description" name="description" rows="6" required class="w-full rounded-[24px] border border-slate-200 bg-white/80 px-4 py-3 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-200/70">{{ old('description', $product->description) }}</textarea>
                @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    {{ __('ui.save_changes') }}
                </button>
            </div>
        </form>

        @if ($product->images->isNotEmpty())
            <div class="mt-8">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('ui.current_images') }}</p>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($product->images as $image)
                        <div class="group relative overflow-hidden rounded-[24px] border border-white/70 bg-white shadow-sm">
                            <a href="{{ $image->url }}" target="_blank">
                                <img src="{{ $image->url }}" alt="{{ $product->title }}" class="h-48 w-full object-cover">
                            </a>
                            <form method="POST" action="{{ route('dashboard.products.images.destroy', [$product, $image]) }}" onsubmit="return confirm('{{ __('ui.confirm_delete_image') }}')" class="absolute right-2 top-2 z-20">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/60 bg-slate-950/90 text-base font-black leading-none text-white shadow-lg ring-2 ring-white/80 transition hover:bg-red-600 hover:scale-105" aria-label="{{ __('ui.delete_image') }}" title="{{ __('ui.delete_image') }}">
                                    ×
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.products.destroy', $product) }}" onsubmit="return confirm('{{ __('ui.confirm_delete_product') }}')" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-2xl border border-red-200 px-5 py-3 text-sm font-semibold text-red-600 transition hover:border-red-300 hover:text-red-700">
                {{ __('ui.delete_product') }}
            </button>
        </form>
    </section>
@endsection