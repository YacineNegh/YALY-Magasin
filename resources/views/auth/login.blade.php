<x-layouts.store title="Admin Login">
    <section class="mx-auto grid min-h-[70vh] max-w-md content-center px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-brand-blush bg-white p-6 shadow-sm">
            <h1 class="text-2xl font-extrabold tracking-tight">Admin login</h1>
            <p class="mt-2 text-sm text-zinc-600">Manage orders, products, categories, and store settings.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 grid gap-4">
                @csrf
                <x-input label="Email" name="email" type="email" autofocus />
                <x-input label="Password" name="password" type="password" />
                <label class="flex items-center gap-2 text-sm font-medium text-zinc-700">
                    <input type="checkbox" name="remember" class="rounded border-brand-blush text-brand-sage focus:ring-brand-sage">
                    <span>Remember me</span>
                </label>
                <button class="rounded-lg bg-brand-sage px-5 py-3 text-sm font-bold text-white hover:bg-brand-ink">Login</button>
            </form>
        </div>
    </section>
</x-layouts.store>
