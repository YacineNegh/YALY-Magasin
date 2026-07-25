<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::status('pending')->count(),
            'confirmedOrders' => Order::status('confirmed')->count(),
            'deliveredOrders' => Order::status('delivered')->count(),
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'recentOrders' => Order::with('items')->latest()->take(8)->get(),
        ]);
    }
}
