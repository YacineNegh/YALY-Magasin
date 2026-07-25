@props(['title' => null, 'heading' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' - ' : '' }}YALY. Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.14.9/dist/cdn.min.js"></script>
    </head>
    <body class="bg-brand-cream font-sans text-brand-ink antialiased">
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-brand-blush bg-white lg:fixed lg:inset-y-0 lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex items-center justify-between px-5 py-5 lg:block">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <x-brand-logo admin />
                    </a>
                </div>

                <nav class="flex gap-2 overflow-x-auto px-5 pb-5 text-sm font-medium lg:grid lg:overflow-visible">
                    <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-admin-nav-link>
                    <x-admin-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">Orders</x-admin-nav-link>
                    <x-admin-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">Products</x-admin-nav-link>
                    <x-admin-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">Categories</x-admin-nav-link>
                    <x-admin-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">Customers</x-admin-nav-link>
                    <x-admin-nav-link :href="route('admin.delivery-prices.index')" :active="request()->routeIs('admin.delivery-prices.*')">Delivery</x-admin-nav-link>
                    <x-admin-nav-link :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.*')">Settings</x-admin-nav-link>
                </nav>
            </aside>

            <div class="min-w-0 flex-1 lg:pl-72">
                <header class="border-b border-brand-blush bg-white">
                    <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                        <div>
                            <p class="text-sm text-zinc-500">Signed in as {{ auth()->user()->name }}</p>
                            <h1 class="text-xl font-bold tracking-tight">{{ $heading ?? 'Admin' }}</h1>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button class="rounded-lg border border-zinc-300 px-4 py-2 text-sm font-semibold hover:bg-zinc-50">Logout</button>
                        </form>
                    </div>
                </header>

                <main class="px-4 py-8 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
