<?php

namespace App\Http\Controllers\PublicStore;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('public.home', [
            'categories' => Category::active()
                ->withCount(['products' => fn (Builder $query) => $query->active()])
                ->latest()
                ->take(6)
                ->get(),
            'featuredProducts' => Product::visible()->featured()->with(['category', 'images'])->latest()->take(4)->get(),
            'latestProducts' => Product::visible()->with(['category', 'images'])->latest()->take(8)->get(),
        ]);
    }
}
