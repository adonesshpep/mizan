<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $products = $this->catalogQuery($search)
            ->paginate(12)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function feed(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('search', ''));

        $products = $this->catalogQuery($search)
            ->paginate(12);

        return response()->json([
            'data' => $products->getCollection()->map(function (Product $product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'description' => $product->description,
                    'detail_url' => route('products.show', $product),
                    'thumbnail' => $product->images->first()?->url,
                    'images' => $product->images->map(fn ($image) => $image->url)->values(),
                ];
            })->values(),
            'next_page_url' => $products->nextPageUrl(),
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['images' => fn ($query) => $query->orderBy('id')]);

        return view('products.show', [
            'product' => $product,
        ]);
    }

    public function dashboard(Request $request)
    {
        if (! $request->session()->get('admin_authenticated', false)) {
            return view('dashboard.login');
        }

        $products = $this->catalogQuery()
            ->paginate(10);

        return view('dashboard.index', [
            'products' => $products,
        ]);
    }

    public function edit(Request $request, Product $product)
    {
        $this->ensureAdmin($request);

        $product->load(['images' => fn ($query) => $query->orderBy('id')]);

        return view('dashboard.edit', [
            'product' => $product,
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => __('ui.password_required'),
        ]);

        if ($validated['password'] !== config('app.admin_password')) {
            throw ValidationException::withMessages([
                'password' => __('ui.password_incorrect'),
            ]);
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'position' => ['required', 'integer', 'min:0'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:5120'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'position' => $validated['position'],
            ]);

            foreach ($request->file('images', []) as $uploadedImage) {
                $path = $uploadedImage->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);
            }
        });

        return redirect()->route('dashboard')->with('status', __('ui.product_added_successfully'));
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'position' => ['required', 'integer', 'min:0'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        DB::transaction(function () use ($validated, $request, $product) {
            $product->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'position' => $validated['position'],
            ]);

            foreach ($request->file('images', []) as $uploadedImage) {
                $path = $uploadedImage->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);
            }
        });

        return redirect()
            ->route('dashboard.products.edit', $product)
            ->with('status', __('ui.product_updated_successfully'));
    }

    public function destroy(Request $request, Product $product)
    {
        $this->ensureAdmin($request);

        DB::transaction(function () use ($product) {
            $product->load('images');

            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->path);
            }

            $product->images()->delete();
            $product->delete();
        });

        return redirect()->route('dashboard')->with('status', __('ui.product_deleted_successfully'));
    }

    public function destroyImage(Request $request, Product $product, Image $image)
    {
        $this->ensureAdmin($request);

        if ($image->product_id !== $product->id) {
            abort(404);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()
            ->route('dashboard.products.edit', $product)
            ->with('status', __('ui.image_deleted_successfully'));
    }

    public function switchLocale(Request $request, string $locale)
    {
        if (! in_array($locale, ['en', 'ar'], true)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);

        return back();
    }

    private function ensureAdmin(Request $request): void
    {
        if (! $request->session()->get('admin_authenticated', false)) {
            abort(403);
        }
    }

    private function catalogQuery(?string $search = null)
    {
        return Product::query()
            ->with(['images' => fn ($query) => $query->orderBy('id')])
            ->when($search !== null && $search !== '', function ($query) use ($search) {
                $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('position')
            ->orderByDesc('created_at');
    }
}
