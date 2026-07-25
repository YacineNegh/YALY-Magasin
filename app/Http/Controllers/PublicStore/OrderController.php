<?php

namespace App\Http\Controllers\PublicStore;

use App\Actions\CreateOrderFromProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, Product $product, CreateOrderFromProduct $createOrder): RedirectResponse
    {
        abort_unless($product->status === 'active', 404);

        $order = $createOrder->execute($product, $request->validated());

        return back()->with('order_success', "Your order {$order->order_number} has been received. We will call you shortly.");
    }
}
