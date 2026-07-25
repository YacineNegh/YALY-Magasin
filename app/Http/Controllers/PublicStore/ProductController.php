<?php

namespace App\Http\Controllers\PublicStore;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::visible()
            ->with(['category', 'images'])
            ->when($request->filled('search'), function (Builder $query) use ($request): void {
                $query->where('name', 'like', '%'.$request->string('search')->toString().'%');
            })
            ->when($request->filled('category'), function (Builder $query) use ($request): void {
                $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('slug', $request->string('category')->toString()));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::active()->orderBy('name')->get(),
            'selectedCategory' => $request->string('category')->toString(),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->status === 'active' && $product->category?->status === 'active', 404);

        $product->load(['category', 'images']);

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => Product::visible()
                ->with(['category', 'images'])
                ->whereBelongsTo($product->category)
                ->whereKeyNot($product->id)
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }
}
