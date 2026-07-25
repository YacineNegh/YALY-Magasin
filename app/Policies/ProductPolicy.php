<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Product;

class ProductPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    public function view(Admin $admin, Product $product): bool
    {
        return true;
    }

    public function create(Admin $admin): bool
    {
        return true;
    }

    public function update(Admin $admin, Product $product): bool
    {
        return true;
    }

    public function delete(Admin $admin, Product $product): bool
    {
        return true;
    }
}
