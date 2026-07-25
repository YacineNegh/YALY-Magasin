<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Category;

class CategoryPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    public function view(Admin $admin, Category $category): bool
    {
        return true;
    }

    public function create(Admin $admin): bool
    {
        return true;
    }

    public function update(Admin $admin, Category $category): bool
    {
        return true;
    }

    public function delete(Admin $admin, Category $category): bool
    {
        return true;
    }
}
