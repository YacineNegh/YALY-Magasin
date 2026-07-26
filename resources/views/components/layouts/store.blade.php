@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}YALY.</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.14.9/dist/cdn.min.js"></script>
    </head>
    <body class="bg-gray-50/50 font-sans text-brand-ink antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="sticky top-0 z-40 border-b border-gray-100 bg-white/90 backdrop-blur">
                <div class="border-b border-gray-100 bg-gray-50/50 text-xs text-gray-600">
                    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                            <span><span class="font-bold text-gray-900">Livraison rapide</span> partout en Algérie</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span>Besoin d'aide ?</span>
                            <div class="flex items-center gap-1 font-bold text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 text-brand-sage">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.076-7.076l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                                <span>+213 5 55 55 55 55</span>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <x-brand-logo />
                    </a>

                    <div class="hidden items-center gap-8 text-sm font-semibold text-gray-800 md:flex">
                        <a class="{{ request()->routeIs('home') ? 'text-brand-sage border-b-2 border-brand-sage pb-1' : 'hover:text-brand-sage pb-1' }}" href="{{ route('home') }}">Accueil</a>
                        <a class="{{ request()->routeIs('products.index') ? 'text-brand-sage border-b-2 border-brand-sage pb-1' : 'hover:text-brand-sage pb-1' }}" href="{{ route('products.index') }}">Produits</a>
                        <a class="{{ request()->routeIs('about') ? 'text-brand-sage border-b-2 border-brand-sage pb-1' : 'hover:text-brand-sage pb-1' }}" href="{{ route('about') }}">À propos</a>
                        <a class="{{ request()->routeIs('contact') ? 'text-brand-sage border-b-2 border-brand-sage pb-1' : 'hover:text-brand-sage pb-1' }}" href="{{ route('contact') }}">Contact</a>
                    </div>

                    <div class="hidden md:block">
                        <form action="{{ route('products.index') }}" class="relative">
                            <input name="search" type="text" placeholder="Rechercher un produit..." class="w-64 rounded-full border border-gray-200 bg-white py-2 pl-4 pr-10 text-sm focus:border-brand-sage focus:outline-none focus:ring-1 focus:ring-brand-sage">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-sage">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </form>
                    </div>

                    <div class="md:hidden" x-data="{ open: false }">
                        <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-brand-ink" x-on:click="open = ! open">Menu</button>
                        <div x-cloak x-show="open" x-transition class="absolute left-4 right-4 top-28 rounded-lg border border-gray-100 bg-white p-4 shadow-xl">
                            <div class="grid gap-3 text-sm font-medium">
                                <a class="{{ request()->routeIs('home') ? 'text-brand-sage' : '' }}" href="{{ route('home') }}">Accueil</a>
                                <a class="{{ request()->routeIs('products.index') ? 'text-brand-sage' : '' }}" href="{{ route('products.index') }}">Produits</a>
                                <a class="{{ request()->routeIs('about') ? 'text-brand-sage' : '' }}" href="{{ route('about') }}">À propos</a>
                                <a class="{{ request()->routeIs('contact') ? 'text-brand-sage' : '' }}" href="{{ route('contact') }}">Contact</a>
                                <form action="{{ route('products.index') }}" class="mt-2 relative">
                                    <input name="search" type="text" placeholder="Rechercher..." class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-4 pr-10 text-sm focus:border-brand-sage focus:outline-none focus:ring-1 focus:ring-brand-sage">
                                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-sage">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-1">
                @if (session('success'))
                    <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="bg-brand-ink text-white">
                <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3 lg:px-8">
                    <div class="flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-white/80">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-bold text-sm">Paiement à la livraison</p>
                            <p class="text-xs text-white/60">Payez à la réception de votre commande</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-white/80">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <div>
                            <p class="font-bold text-sm">Besoin d'aide ?</p>
                            <p class="text-xs text-white/60">+213 5 55 55 55 55</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-white/80">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-bold text-sm">Horaires d'ouvertures</p>
                            <p class="text-xs text-white/60">Samedi - Jeudi : 09h00 - 18h00</p>
                            <a href="{{ route('login') }}" class="text-xs text-white/40 hover:text-white transition mt-1 block">Admin Login</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
