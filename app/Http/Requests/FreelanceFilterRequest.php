<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreelanceFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'level' => 'nullable|in:junior,intermédiaire,confirmé,expert',
            'min_experience' => 'nullable|integer|min:0',
            'max_experience' => 'nullable|integer|min:0',
            'available' => 'nullable|boolean',
            'min_price' => 'nullable|integer|min:0',
            'max_price' => 'nullable|integer|min:0',
            'city' => 'nullable|string|max:255',
            'professions' => 'nullable|array',
            'professions.*' => 'string',
            'skills' => 'nullable|array',
            'skills.*' => 'string',
            'sort' => 'nullable|in:price_asc,price_desc,experience,recent',
            'page' => 'nullable|integer|min:1',
        ];
    }
}
