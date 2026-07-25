<x-layouts.store :title="$product->name">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1fr_420px]">
            <div x-data="{ active: @js($product->images->first()?->url()) }">
                <div class="overflow-hidden rounded-lg border border-brand-blush bg-white">
                    @if ($product->images->isNotEmpty())
                        <img x-bind:src="active" alt="{{ $product->name }}" class="aspect-square w-full object-cover">
                    @else
                        <div class="grid aspect-square place-items-center bg-brand-blush/40 text-2xl font-black text-brand-sage">YALY.</div>
                    @endif
                </div>
                @if ($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach ($product->images as $image)
                            <button type="button" x-on:click="active = @js($image->url())" class="overflow-hidden rounded-lg border border-brand-blush bg-white">
                                <img src="{{ $image->url() }}" alt="{{ $image->alt_text ?? $product->name }}" class="aspect-square w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif

                <div class="mt-8 rounded-lg border border-brand-blush bg-white p-6">
                    <p class="text-sm font-bold uppercase tracking-wide text-brand-coral">{{ $product->category->name }}</p>
                    <h1 class="mt-2 text-3xl font-extrabold tracking-tight">{{ $product->name }}</h1>
                    <p class="mt-4 text-2xl font-black">{{ number_format((float) $product->price, 2) }} DA</p>
                    <div class="mt-4">
                        <x-status-badge :status="$product->stock > 0 ? 'active' : 'inactive'">{{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}</x-status-badge>
                    </div>
                    <div class="prose mt-6 max-w-none text-zinc-700">
                        <p>{{ $product->description }}</p>
                    </div>
                    @if ($product->specifications)
                        <div class="mt-6 border-t border-brand-blush pt-6">
                            <h2 class="font-bold">Specifications</h2>
                            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-zinc-600">{{ $product->specifications }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <aside class="lg:sticky lg:top-24 lg:self-start">
                <div class="rounded-lg border border-brand-blush bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold tracking-tight">Order this product</h2>
                    <p class="mt-2 text-sm leading-6 text-zinc-600">Submit your details. The administrator will call to confirm the order.</p>

                    @if (session('order_success'))
                        <div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">{{ session('order_success') }}</div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('orders.store', $product) }}"
                        class="mt-6 grid gap-4"
                        x-data="YLStore.deliveryOrderForm({
                            wilayasUrl: @js(route('locations.wilayas')),
                            communesUrlTemplate: @js(url('/api/locations/wilayas/__WILAYA__/communes')),
                            productPrice: @js((float) $product->price),
                            initialQuantity: @js((int) old('quantity', 1)),
                            oldWilayaId: @js(old('wilaya_id')),
                            oldCommuneId: @js(old('commune_id')),
                            maxQuantity: @js(max(1, $product->stock)),
                        })"
                        x-init="init()"
                    >
                        @csrf
                        <x-input label="Full Name" name="full_name" />
                        <x-input label="Phone Number" name="phone" />
                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="grid gap-2 text-sm font-medium text-zinc-800">
                                <span>Wilaya</span>
                                <select
                                    name="wilaya_id"
                                    x-model="wilayaId"
                                    x-on:change="communeId = ''; loadCommunes()"
                                    class="rounded-lg border-brand-blush bg-white text-brand-ink shadow-sm focus:border-brand-sage focus:ring-brand-sage"
                                >
                                    <option value="" x-text="loadingWilayas ? 'Loading wilayas...' : 'Choose wilaya'"></option>
                                    <template x-for="wilaya in wilayas" :key="wilaya.id">
                                        <option :value="String(wilaya.id)" x-text="wilaya.label"></option>
                                    </template>
                                </select>
                                @error('wilaya_id')
                                    <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="grid gap-2 text-sm font-medium text-zinc-800">
                                <span>Commune</span>
                                <select
                                    name="commune_id"
                                    x-model="communeId"
                                    x-bind:disabled="! wilayaId || loadingCommunes"
                                    class="rounded-lg border-brand-blush bg-white text-brand-ink shadow-sm disabled:bg-brand-cream disabled:text-zinc-500 focus:border-brand-sage focus:ring-brand-sage"
                                >
                                    <option value="" x-text="communePlaceholder"></option>
                                    <template x-for="commune in communes" :key="commune.id">
                                        <option :value="String(commune.id)" x-text="communeLabel(commune)"></option>
                                    </template>
                                </select>
                                @error('commune_id')
                                    <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <x-textarea label="Full Address" name="address" rows="3" />
                        <label class="grid gap-2 text-sm font-medium text-zinc-800">
                            <span>Quantity</span>
                            <div class="flex h-11 overflow-hidden rounded-lg border border-brand-blush bg-white">
                                <button type="button" class="w-12 border-r border-brand-blush font-bold text-brand-sage" x-on:click="quantity = Math.max(1, quantity - 1)">-</button>
                                <input name="quantity" x-model.number="quantity" type="number" min="1" max="{{ max(1, $product->stock) }}" class="min-w-0 flex-1 border-0 text-center focus:ring-0">
                                <button type="button" class="w-12 border-l border-brand-blush font-bold text-brand-sage" x-on:click="quantity = Math.min(maxQuantity, Number(quantity || 1) + 1)">+</button>
                            </div>
                            @error('quantity')
                                <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
                            @enderror
                        </label>
                        <x-textarea label="Notes" name="notes" rows="3" />

                        <div class="rounded-lg border border-brand-blush bg-brand-cream p-4 text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-zinc-600">Products</span>
                                <span class="font-bold" x-text="formatPrice(itemsTotal) + ' DA'"></span>
                            </div>
                            <div class="mt-2 flex items-center justify-between gap-4">
                                <span class="text-zinc-600">Delivery</span>
                                <span class="font-bold" x-text="wilayaId ? formatPrice(deliveryPrice) + ' DA' : 'Choose wilaya'"></span>
                            </div>
                            <div class="mt-3 border-t border-brand-blush pt-3 flex items-center justify-between gap-4">
                                <span class="font-bold">Estimated total</span>
                                <span class="text-lg font-black text-brand-sage" x-text="formatPrice(estimatedTotal) + ' DA'"></span>
                            </div>
                        </div>

                        <button class="rounded-lg bg-brand-sage px-5 py-3 text-sm font-bold text-white hover:bg-brand-ink" @disabled($product->stock < 1)>Submit Order</button>
                    </form>
                </div>
            </aside>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-extrabold tracking-tight">Related products</h2>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-layouts.store>
