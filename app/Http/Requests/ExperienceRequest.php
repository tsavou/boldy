<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'company.required' => 'Le nom de l\'entreprise est obligatoire.',
            'start_date.required' => 'La date de début est obligatoire.',
            'end_date.after_or_equal' => 'La date de fin doit être après ou égale à la date de début.',
        ];
    }
}
