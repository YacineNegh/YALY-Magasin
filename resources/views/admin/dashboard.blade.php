<x-layouts.admin title="Dashboard" heading="Dashboard">
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
        <x-admin-stat label="Total Orders" :value="$totalOrders" />
        <x-admin-stat label="Pending Orders" :value="$pendingOrders" />
        <x-admin-stat label="Confirmed Orders" :value="$confirmedOrders" />
        <x-admin-stat label="Delivered Orders" :value="$deliveredOrders" />
        <x-admin-stat label="Products" :value="$productsCount" />
        <x-admin-stat label="Categories" :value="$categoriesCount" />
    </div>

    <section class="mt-8 rounded-lg border border-brand-blush bg-white shadow-sm">
        <div class="flex items-center justify-between gap-4 border-b border-brand-blush px-5 py-4">
            <h2 class="font-bold">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-brand-sage hover:text-brand-ink">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-blush text-sm">
                <thead class="bg-brand-cream text-left text-xs font-bold uppercase tracking-wide text-brand-coral">
                    <tr>
                        <th class="px-5 py-3">ID</th>
                        <th class="px-5 py-3">Customer</th>
                        <th class="px-5 py-3">Phone</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-blush/60">
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td class="px-5 py-4 font-bold">{{ $order->order_number }}</td>
                            <td class="px-5 py-4">{{ $order->full_name }}</td>
                            <td class="px-5 py-4">{{ $order->phone }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$order->status" /></td>
                            <td class="px-5 py-4 text-zinc-600">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.admin>
