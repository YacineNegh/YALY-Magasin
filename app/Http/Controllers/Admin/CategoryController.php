<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Category::class);

        return view('admin.categories.index', [
            'categories' => Category::withCount('products')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Category::class);

        return view('admin.categories.create', ['category' => new Category()]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Gate::authorize('create', Category::class);

        Category::create([
            ...$request->validated(),
            'slug' => Str::slug($request->validated('name')),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category): View
    {
        Gate::authorize('update', $category);

        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);

        $category->update([
            ...$request->validated(),
            'slug' => Str::slug($request->validated('name')),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        Gate::authorize('delete', $category);

        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
