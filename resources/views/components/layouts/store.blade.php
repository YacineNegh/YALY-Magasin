@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}YALY.</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.14.9/dist/cdn.min.js"></script>
    </head>
    <body class="bg-brand-cream font-sans text-brand-ink antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="sticky top-0 z-40 border-b border-brand-blush/70 bg-brand-cream/90 backdrop-blur">
                <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <x-brand-logo />
                    </a>

                    <div class="hidden items-center gap-7 text-sm font-medium text-brand-ink/70 md:flex">
                        <a class="hover:text-brand-sage" href="{{ route('home') }}">Home</a>
                        <a class="hover:text-brand-sage" href="{{ route('products.index') }}">Products</a>
                        <a class="hover:text-brand-sage" href="{{ route('about') }}">About</a>
                        <a class="hover:text-brand-sage" href="{{ route('contact') }}">Contact</a>
                    </div>

                    <a href="{{ route('products.index') }}" class="hidden rounded-lg bg-brand-sage px-4 py-2 text-sm font-semibold text-white shadow-sm shadow-brand-sage/20 hover:bg-brand-ink sm:inline-flex">Shop now</a>

                    <div class="md:hidden" x-data="{ open: false }">
                        <button type="button" class="rounded-lg border border-brand-blush px-3 py-2 text-sm font-semibold text-brand-ink" x-on:click="open = ! open">Menu</button>
                        <div x-cloak x-show="open" x-transition class="absolute left-4 right-4 top-16 rounded-lg border border-brand-blush bg-white p-4 shadow-xl">
                            <div class="grid gap-3 text-sm font-medium">
                                <a href="{{ route('home') }}">Home</a>
                                <a href="{{ route('products.index') }}">Products</a>
                                <a href="{{ route('about') }}">About</a>
                                <a href="{{ route('contact') }}">Contact</a>
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

            <footer class="border-t border-brand-blush bg-white">
                <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-4 lg:px-8">
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-3">
                            <x-brand-logo />
                        </div>
                        <p class="mt-4 max-w-md text-sm leading-6 text-zinc-600">Curated products, direct ordering, and a real call from the store owner before every confirmation.</p>
                    </div>
                    <div>
                        <p class="font-semibold">Store</p>
                        <div class="mt-4 grid gap-2 text-sm text-zinc-600">
                            <a href="{{ route('products.index') }}">Products</a>
                            <a href="{{ route('about') }}">About</a>
                            <a href="{{ route('contact') }}">Contact</a>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold">Contact</p>
                        <div class="mt-4 grid gap-2 text-sm text-zinc-600">
                            <span>Algeria</span>
                            <span>Phone orders daily</span>
                            <a href="{{ route('login') }}">Admin</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
