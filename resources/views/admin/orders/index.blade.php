<x-layouts.admin title="Orders" heading="Orders">
    <section class="rounded-lg border border-brand-blush bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-blush text-sm">
                <thead class="bg-brand-cream text-left text-xs font-bold uppercase tracking-wide text-brand-coral">
                    <tr>
                        <th class="px-5 py-3">ID</th>
                        <th class="px-5 py-3">Customer</th>
                        <th class="px-5 py-3">Phone</th>
                        <th class="px-5 py-3">Product</th>
                        <th class="px-5 py-3">Quantity</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-blush/60">
                    @foreach ($orders as $order)
                        @php($item = $order->items->first())
                        <tr>
                            <td class="px-5 py-4 font-bold">{{ $order->order_number }}</td>
                            <td class="px-5 py-4">{{ $order->full_name }}</td>
                            <td class="px-5 py-4">{{ $order->phone }}</td>
                            <td class="px-5 py-4">{{ $item?->product_name }}</td>
                            <td class="px-5 py-4">{{ $item?->quantity }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$order->status" /></td>
                            <td class="px-5 py-4 text-zinc-600">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="rounded-lg border border-brand-blush px-3 py-1.5 font-semibold text-brand-ink hover:bg-brand-cream">View</a>
                                    <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">@csrf @method('PATCH')<button class="rounded-lg bg-brand-sage px-3 py-1.5 font-semibold text-white hover:bg-brand-ink">Confirm</button></form>
                                    <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">@csrf @method('PATCH')<button class="rounded-lg bg-brand-coral px-3 py-1.5 font-semibold text-white hover:bg-brand-ink">Cancel</button></form>
                                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}">@csrf @method('DELETE')<button class="rounded-lg bg-red-600 px-3 py-1.5 font-semibold text-white hover:bg-red-700">Delete</button></form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div class="mt-6">{{ $orders->links() }}</div>
</x-layouts.admin>
