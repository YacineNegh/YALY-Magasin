<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use App\Models\Wilaya;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateDeliveryPricesRequest extends FormRequest
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
        return [
            'wilayas' => ['required', 'array', 'min:1'],
            'wilayas.*.delivery_price' => ['required', 'numeric', 'min:0', 'max:999999'],
            'wilayas.*.is_delivery_available' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $submittedIds = collect(array_keys($this->input('wilayas', [])));

                if ($submittedIds->contains(fn (string|int $id): bool => ! ctype_digit((string) $id))) {
                    $validator->errors()->add('wilayas', 'One or more wilayas are invalid.');

                    return;
                }

                $wilayaIds = $submittedIds
                    ->map(fn (string|int $id): int => (int) $id)
                    ->values();

                if ($wilayaIds->isEmpty()) {
                    return;
                }

                $existingCount = Wilaya::query()->whereKey($wilayaIds->all())->count();

                if ($existingCount !== $wilayaIds->count()) {
                    $validator->errors()->add('wilayas', 'One or more wilayas are invalid.');
                }
            },
        ];
    }
}
