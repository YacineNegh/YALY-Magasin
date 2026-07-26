<x-layouts.store title="Home">
    <section class="bg-gray-50/50 pt-8 pb-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-brand-blush/30 lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div class="px-6 pt-10 pb-12 sm:px-12 lg:py-16 lg:px-16 xl:p-20">
                    <p class="text-sm font-bold text-brand-sage mb-4">Découvrez nos produits</p>
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl mb-6">
                        Qualité, Style <br><span class="text-brand-sage">et Confiance</span>
                    </h1>
                    <p class="text-lg text-gray-700 mb-8 max-w-lg">Parcourez notre sélection de produits de qualité et passez votre commande en toute simplicité.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-sage px-6 py-3.5 text-base font-bold text-white shadow-lg shadow-brand-sage/30 hover:bg-brand-ink transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        Voir nos produits
                    </a>
                    
                    <div class="mt-12 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                        <div class="flex items-start gap-3">
                            <div class="rounded-lg bg-white p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-sage"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Produits de qualité</p>
                                <p class="text-xs text-gray-500">Sélectionnés avec soin</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="rounded-lg bg-white p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-sage"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Livraison rapide</p>
                                <p class="text-xs text-gray-500">Partout en Algérie</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="rounded-lg bg-white p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-brand-sage"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.076-7.076l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Commande simple</p>
                                <p class="text-xs text-gray-500">Remplissez le formulaire</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative h-64 sm:h-80 lg:h-full flex items-center justify-center p-8">
                    @if ($featuredProducts->first()?->imageUrl())
                        <img src="{{ $featuredProducts->first()->imageUrl() }}" alt="{{ $featuredProducts->first()->name }}" class="object-contain h-full w-full max-h-96 scale-110 drop-shadow-2xl">
                    @else
                        <div class="h-64 w-64 rounded-full bg-brand-sage/20 flex items-center justify-center">
                            <span class="text-3xl font-black text-brand-sage">YΛLY.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50/50 py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Nos catégories</h2>
                <div class="mx-auto mt-3 h-1 w-12 rounded bg-brand-sage"></div>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group flex flex-col items-center rounded-2xl bg-white p-8 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md border border-gray-100">
                        <div class="mb-4 text-brand-sage">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 mx-auto">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 font-bold text-gray-900">{{ $category->name }}</h3>
                        <span class="text-sm font-medium text-brand-sage group-hover:text-brand-ink transition">Voir les produits &rarr;</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gray-50/50 pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between rounded-2xl bg-white p-8 shadow-sm border border-gray-100 gap-8">
                <div class="flex items-center gap-4 flex-1">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-sage text-xl font-bold text-white shadow-md shadow-brand-sage/30">1</div>
                    <div>
                        <h3 class="font-bold text-gray-900">Choisissez vos produits</h3>
                        <p class="text-sm text-gray-500 mt-1 leading-snug">Parcourez notre catalogue et sélectionnez vos articles préférés.</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 flex-1">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-sage text-xl font-bold text-white shadow-md shadow-brand-sage/30">2</div>
                    <div>
                        <h3 class="font-bold text-gray-900">Remplissez le formulaire</h3>
                        <p class="text-sm text-gray-500 mt-1 leading-snug">Complétez le formulaire de commande avec vos informations.</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 flex-1">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-sage text-xl font-bold text-white shadow-md shadow-brand-sage/30">3</div>
                    <div>
                        <h3 class="font-bold text-gray-900">Nous vous contactons</h3>
                        <p class="text-sm text-gray-500 mt-1 leading-snug">Notre équipe vous appellera pour confirmer votre commande.</p>
                    </div>
                    <div class="ml-auto hidden rounded-full bg-brand-blush/40 p-4 text-brand-sage lg:block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.076-7.076l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">Derniers produits</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-bold text-brand-sage hover:text-brand-ink transition">Voir tout le catalogue &rarr;</a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($latestProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.store>
