<?php

namespace App\Actions;

use App\Models\Commune;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wilaya;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateOrderFromProduct
{
    /**
     * @param array{full_name: string, phone: string, wilaya_id: int, commune_id: int, address: string, quantity: int, notes?: string|null} $data
     */
    public function execute(Product $product, array $data): Order
    {
        return DB::transaction(function () use ($product, $data): Order {
            $quantity = (int) $data['quantity'];
            $itemsTotal = (float) $product->price * $quantity;
            $wilaya = Wilaya::query()->deliveryAvailable()->findOrFail($data['wilaya_id']);
            $commune = Commune::query()
                ->whereBelongsTo($wilaya)
                ->findOrFail($data['commune_id']);
            $deliveryPrice = (float) $wilaya->delivery_price;

            $order = Order::create([
                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'wilaya_id' => $wilaya->id,
                'commune_id' => $commune->id,
                'wilaya' => $wilaya->name,
                'commune' => $commune->name,
                'address' => $data['address'],
                'notes' => $data['notes'] ?? null,
                'order_number' => $this->orderNumber(),
                'items_total' => $itemsTotal,
                'delivery_price' => $deliveryPrice,
                'total' => $itemsTotal + $deliveryPrice,
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $itemsTotal,
            ]);

            return $order->load('items.product');
        });
    }

    private function orderNumber(): string
    {
        do {
            $orderNumber = 'YL-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
