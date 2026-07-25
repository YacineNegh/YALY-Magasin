@props(['label', 'name', 'value' => null])

<label class="grid gap-2 text-sm font-medium text-zinc-800">
    <span>{{ $label }}</span>
    <textarea
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'min-h-28 rounded-lg border-brand-blush bg-white text-brand-ink shadow-sm focus:border-brand-sage focus:ring-brand-sage']) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
    @enderror
</label>
