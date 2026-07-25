<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Product::class);

        return view('admin.products.index', [
            'products' => Product::with(['category', 'images'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Product::class);

        return view('admin.products.create', [
            'product' => new Product(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Gate::authorize('create', Product::class);

        $product = Product::create($this->productData($request->validated()));
        $this->storeImages($product, $request->file('images', []));

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        Gate::authorize('update', $product);

        return view('admin.products.edit', [
            'product' => $product->load('images'),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        Gate::authorize('update', $product);

        $product->update($this->productData($request->validated()));
        $this->storeImages($product, $request->file('images', []));

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        Gate::authorize('delete', $product);

        foreach ($product->images as $image) {
            if (! Str::startsWith($image->image_path, ['http://', 'https://'])) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function productData(array $data): array
    {
        return [
            ...$data,
            'slug' => Str::slug((string) $data['name']),
            'is_featured' => (bool) ($data['is_featured'] ?? false),
        ];
    }

    /**
     * @param array<int, UploadedFile> $images
     */
    private function storeImages(Product $product, array $images): void
    {
        $existingImagesCount = $product->images()->count();

        foreach ($images as $index => $image) {
            $product->images()->create([
                'image_path' => $image->store('products', 'public'),
                'alt_text' => $product->name,
                'is_primary' => $existingImagesCount === 0 && $index === 0,
                'sort_order' => $existingImagesCount + $index,
            ]);
        }
    }
}
