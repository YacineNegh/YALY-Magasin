<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
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
        /** @var Admin $admin */
        $admin = $this->user();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($admin)],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];
    }
}
