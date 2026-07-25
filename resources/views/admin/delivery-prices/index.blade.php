<x-layouts.admin title="Delivery Prices" heading="Delivery Prices">
    <form method="POST" action="{{ route('admin.delivery-prices.update') }}" class="grid gap-6">
        @csrf
        @method('PUT')

        <section class="rounded-lg border border-brand-blush bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-brand-blush px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-bold">Algeria Wilayas</h2>
                    <p class="mt-1 text-sm text-zinc-600">Update local delivery prices and availability for each wilaya.</p>
                </div>
                <button class="rounded-lg bg-brand-sage px-4 py-2 text-sm font-bold text-white hover:bg-brand-ink">Save Prices</button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-brand-blush text-sm">
                    <thead class="bg-brand-cream text-left text-xs font-bold uppercase tracking-wide text-brand-coral">
                        <tr>
                            <th class="px-5 py-3">Code</th>
                            <th class="px-5 py-3">Wilaya</th>
                            <th class="px-5 py-3">Communes</th>
                            <th class="px-5 py-3">Delivery Price</th>
                            <th class="px-5 py-3">Available</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-blush/60">
                        @foreach ($wilayas as $wilaya)
                            <tr>
                                <td class="px-5 py-4 font-bold">{{ str_pad((string) $wilaya->code, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold">{{ $wilaya->name }}</div>
                                    @if ($wilaya->name_ar)
                                        <div class="mt-1 text-xs text-zinc-500">{{ $wilaya->name_ar }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-zinc-600">{{ $wilaya->communes_count }}</td>
                                <td class="px-5 py-4">
                                    <label class="sr-only" for="wilaya-{{ $wilaya->id }}-delivery-price">Delivery price for {{ $wilaya->name }}</label>
                                    <div class="flex w-44 overflow-hidden rounded-lg border border-brand-blush bg-white focus-within:border-brand-sage focus-within:ring-1 focus-within:ring-brand-sage">
                                        <input
                                            id="wilaya-{{ $wilaya->id }}-delivery-price"
                                            name="wilayas[{{ $wilaya->id }}][delivery_price]"
                                            type="number"
                                            min="0"
                                            step="50"
                                            value="{{ old("wilayas.{$wilaya->id}.delivery_price", $wilaya->delivery_price) }}"
                                            class="min-w-0 flex-1 border-0 text-sm focus:ring-0"
                                        >
                                        <span class="grid place-items-center border-l border-brand-blush px-3 text-xs font-bold text-zinc-500">DA</span>
                                    </div>
                                    @error("wilayas.{$wilaya->id}.delivery_price")
                                        <div class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td class="px-5 py-4">
                                    <input type="hidden" name="wilayas[{{ $wilaya->id }}][is_delivery_available]" value="0">
                                    <label class="inline-flex items-center gap-2 font-semibold text-brand-ink">
                                        <input
                                            type="checkbox"
                                            name="wilayas[{{ $wilaya->id }}][is_delivery_available]"
                                            value="1"
                                            @checked((bool) old("wilayas.{$wilaya->id}.is_delivery_available", $wilaya->is_delivery_available))
                                            class="rounded border-brand-blush text-brand-sage focus:ring-brand-sage"
                                        >
                                        Active
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </form>
</x-layouts.admin>
