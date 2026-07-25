<x-layouts.admin title="Settings" heading="Settings">
    <x-admin-panel class="max-w-2xl">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="grid gap-5">
            @csrf
            @method('PUT')
            <x-input label="Admin Name" name="name" :value="$admin->name" />
            <x-input label="Admin Email" name="email" type="email" :value="$admin->email" />
            <x-input label="New Password" name="password" type="password" />
            <x-input label="Confirm New Password" name="password_confirmation" type="password" />
            <div class="flex justify-end">
                <button class="rounded-lg bg-brand-sage px-4 py-2 text-sm font-bold text-white hover:bg-brand-ink">Save Settings</button>
            </div>
        </form>
    </x-admin-panel>
</x-layouts.admin>
