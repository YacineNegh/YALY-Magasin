<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() instanceof Admin;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($product)],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'specifications' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'is_featured' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
