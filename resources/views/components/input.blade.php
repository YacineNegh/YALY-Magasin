@props(['label', 'name', 'type' => 'text', 'value' => null])

<label class="grid gap-2 text-sm font-medium text-zinc-800">
    <span>{{ $label }}</span>
    <input
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'rounded-lg border-brand-blush bg-white text-brand-ink shadow-sm focus:border-brand-sage focus:ring-brand-sage']) }}
    >
    @error($name)
        <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
    @enderror
</label>
