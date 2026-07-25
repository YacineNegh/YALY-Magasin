<x-layouts.admin :title="$order->order_number" :heading="$order->order_number">
    <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
        <section class="rounded-lg border border-brand-blush bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-bold">Order Details</h2>
                <x-status-badge :status="$order->status" />
            </div>
            <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                <div><dt class="text-xs font-bold uppercase text-zinc-500">Customer</dt><dd class="mt-1 font-semibold">{{ $order->full_name }}</dd></div>
                <div><dt class="text-xs font-bold uppercase text-zinc-500">Phone</dt><dd class="mt-1 font-semibold">{{ $order->phone }}</dd></div>
                <div><dt class="text-xs font-bold uppercase text-zinc-500">Wilaya</dt><dd class="mt-1">{{ $order->wilaya }}</dd></div>
                <div><dt class="text-xs font-bold uppercase text-zinc-500">Commune</dt><dd class="mt-1">{{ $order->commune }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs font-bold uppercase text-zinc-500">Address</dt><dd class="mt-1">{{ $order->address }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs font-bold uppercase text-zinc-500">Notes</dt><dd class="mt-1">{{ $order->notes ?: 'No notes' }}</dd></div>
            </dl>

            <div class="mt-8 overflow-x-auto">
                <table class="min-w-full divide-y divide-brand-blush text-sm">
                    <thead class="text-left text-xs font-bold uppercase text-brand-coral">
                        <tr><th class="py-3">Product</th><th class="py-3">Qty</th><th class="py-3">Price</th><th class="py-3">Subtotal</th></tr>
                    </thead>
                    <tbody class="divide-y divide-brand-blush/60">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="py-4 font-semibold">{{ $item->product_name }}</td>
                                <td class="py-4">{{ $item->quantity }}</td>
                                <td class="py-4">{{ number_format((float) $item->unit_price, 2) }} DA</td>
                                <td class="py-4 font-bold">{{ number_format((float) $item->subtotal, 2) }} DA</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 grid gap-2 rounded-lg bg-brand-cream p-4 text-sm sm:ml-auto sm:max-w-xs">
                <div class="flex items-center justify-between gap-4">
                    <span class="text-zinc-600">Products</span>
                    <span class="font-bold">{{ number_format((float) $order->items_total, 2) }} DA</span>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-zinc-600">Delivery</span>
                    <span class="font-bold">{{ number_format((float) $order->delivery_price, 2) }} DA</span>
                </div>
                <div class="border-t border-brand-blush pt-2 flex items-center justify-between gap-4">
                    <span class="font-bold">Total</span>
                    <span class="text-lg font-black text-brand-sage">{{ number_format((float) $order->total, 2) }} DA</span>
                </div>
            </div>
        </section>

        <aside class="rounded-lg border border-brand-blush bg-white p-6 shadow-sm">
            <h2 class="font-bold">Actions</h2>
            <div class="mt-4 grid gap-3">
                <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">@csrf @method('PATCH')<button class="w-full rounded-lg bg-brand-sage px-4 py-2 font-bold text-white hover:bg-brand-ink">Confirm</button></form>
                <form method="POST" action="{{ route('admin.orders.deliver', $order) }}">@csrf @method('PATCH')<button class="w-full rounded-lg bg-brand-sage px-4 py-2 font-bold text-white hover:bg-brand-ink">Delivered</button></form>
                <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">@csrf @method('PATCH')<button class="w-full rounded-lg bg-brand-coral px-4 py-2 font-bold text-white hover:bg-brand-ink">Cancel</button></form>
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}">@csrf @method('DELETE')<button class="w-full rounded-lg bg-red-600 px-4 py-2 font-bold text-white">Delete</button></form>
            </div>
        </aside>
    </div>
</x-layouts.admin>
