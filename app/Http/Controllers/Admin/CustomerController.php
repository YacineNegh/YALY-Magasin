<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Order::query()
            ->selectRaw('phone, max(full_name) as full_name, max(wilaya) as wilaya, max(commune) as commune, count(*) as orders_count, sum(total) as total_spent, max(created_at) as last_order_at')
            ->groupBy('phone')
            ->latest('last_order_at')
            ->paginate(15);

        return view('admin.customers.index', ['customers' => $customers]);
    }
}
