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
            'available' => 'nullable|boolean',
            'job'       => 'nullable|string|max:100',
            'skill'     => 'nullable|string|max:255',
            'city'      => 'nullable|string',
            'search'    => 'nullable|string',
            'min_price' => 'nullable|integer|min:0',
            'max_price' => 'nullable|integer|min:0',
            'level'     => 'nullable|array',
            'level.*'   => 'string|in:Junior,Intermédiaire,Confirmé,Expert',
            'min_exp'   => 'nullable|integer|min:0',
            'max_exp'   => 'nullable|integer|min:0',
            'sort'      => 'nullable|in:price_asc,price_desc,experience_asc,experience_desc,recent',
            'page'      => 'nullable|integer|min:1',
        ];
    }
}
