<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1950|max:' . date('Y'),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
