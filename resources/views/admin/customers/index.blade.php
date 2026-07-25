<x-layouts.admin title="Customers" heading="Customers">
    <section class="rounded-lg border border-brand-blush bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-blush text-sm">
                <thead class="bg-brand-cream text-left text-xs font-bold uppercase tracking-wide text-brand-coral">
                    <tr>
                        <th class="px-5 py-3">Customer</th>
                        <th class="px-5 py-3">Phone</th>
                        <th class="px-5 py-3">Location</th>
                        <th class="px-5 py-3">Orders</th>
                        <th class="px-5 py-3">Total</th>
                        <th class="px-5 py-3">Last Order</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-blush/60">
                    @foreach ($customers as $customer)
                        <tr>
                            <td class="px-5 py-4 font-bold">{{ $customer->full_name }}</td>
                            <td class="px-5 py-4">{{ $customer->phone }}</td>
                            <td class="px-5 py-4">{{ $customer->wilaya }}, {{ $customer->commune }}</td>
                            <td class="px-5 py-4">{{ $customer->orders_count }}</td>
                            <td class="px-5 py-4 font-semibold">{{ number_format((float) $customer->total_spent, 2) }} DA</td>
                            <td class="px-5 py-4 text-zinc-600">{{ \Illuminate\Support\Carbon::parse($customer->last_order_at)->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div class="mt-6">{{ $customers->links() }}</div>
</x-layouts.admin>
