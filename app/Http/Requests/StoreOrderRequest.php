<?php

namespace App\Http\Requests;

use App\Models\Commune;
use App\Models\Product;
use App\Models\Wilaya;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'wilaya_id' => [
                'required',
                'integer',
                Rule::exists((new Wilaya)->getTable(), 'id')->where('is_delivery_available', true),
            ],
            'commune_id' => ['required', 'integer', Rule::exists((new Commune)->getTable(), 'id')],
            'address' => ['required', 'string', 'max:1000'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $product = $this->route('product');

                if (! $product instanceof Product) {
                    return;
                }

                if ($product->stock < $this->integer('quantity')) {
                    $validator->errors()->add('quantity', 'The requested quantity is not available.');
                }

                if (! $this->filled(['wilaya_id', 'commune_id'])) {
                    return;
                }

                $communeBelongsToWilaya = Commune::query()
                    ->whereKey($this->integer('commune_id'))
                    ->where('wilaya_id', $this->integer('wilaya_id'))
                    ->exists();

                if (! $communeBelongsToWilaya) {
                    $validator->errors()->add('commune_id', 'Please choose a commune from the selected wilaya.');
                }
            },
        ];
    }
}
