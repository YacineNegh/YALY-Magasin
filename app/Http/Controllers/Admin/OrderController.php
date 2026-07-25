<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Order::class);

        return view('admin.orders.index', [
            'orders' => Order::with('items.product')->latest()->paginate(15),
        ]);
    }

    public function show(Order $order): View
    {
        Gate::authorize('view', $order);

        return view('admin.orders.show', [
            'order' => $order->load('items.product'),
        ]);
    }

    public function confirm(Order $order): RedirectResponse
    {
        Gate::authorize('update', $order);

        $updated = DB::transaction(function () use ($order): bool {
            $lockedOrder = $this->lockedOrder($order);

            if (! $this->hasReservedStock($lockedOrder) && ! $this->reserveStock($lockedOrder)) {
                return false;
            }

            $lockedOrder->update(['status' => 'confirmed']);

            return true;
        });

        if (! $updated) {
            return back()->withErrors(['order' => 'One or more products do not have enough stock.']);
        }

        return back()->with('success', 'Order confirmed.');
    }

    public function cancel(Order $order): RedirectResponse
    {
        Gate::authorize('update', $order);

        DB::transaction(function () use ($order): void {
            $lockedOrder = $this->lockedOrder($order);

            if ($this->hasReservedStock($lockedOrder)) {
                $this->releaseStock($lockedOrder);
            }

            $lockedOrder->update(['status' => 'cancelled']);
        });

        return back()->with('success', 'Order cancelled.');
    }

    public function deliver(Order $order): RedirectResponse
    {
        Gate::authorize('update', $order);

        $updated = DB::transaction(function () use ($order): bool {
            $lockedOrder = $this->lockedOrder($order);

            if (! $this->hasReservedStock($lockedOrder) && ! $this->reserveStock($lockedOrder)) {
                return false;
            }

            $lockedOrder->update(['status' => 'delivered']);

            return true;
        });

        if (! $updated) {
            return back()->withErrors(['order' => 'One or more products do not have enough stock.']);
        }

        return back()->with('success', 'Order marked as delivered.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        Gate::authorize('delete', $order);

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }

    private function lockedOrder(Order $order): Order
    {
        return Order::with('items')
            ->whereKey($order->getKey())
            ->lockForUpdate()
            ->firstOrFail();
    }

    private function hasReservedStock(Order $order): bool
    {
        return in_array($order->status, ['confirmed', 'delivered'], true);
    }

    private function reserveStock(Order $order): bool
    {
        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            $product = Product::whereKey($item->product_id)->lockForUpdate()->first();

            if ($product && $product->stock < $item->quantity) {
                return false;
            }

            $product?->decrement('stock', $item->quantity);
        }

        return true;
    }

    private function releaseStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            $product = Product::whereKey($item->product_id)
                ->lockForUpdate()
                ->first();

            $product?->increment('stock', $item->quantity);
        }
    }
}
