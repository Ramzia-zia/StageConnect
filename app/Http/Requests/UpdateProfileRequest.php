<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
        ];

        if ($this->user()->role === 'student') {
            $rules['phone'] = ['nullable', 'string', 'max:20'];
            $rules['bio'] = ['nullable', 'string'];
            $rules['education_level'] = ['nullable', 'string', 'max:255'];
            $rules['skills'] = ['nullable', 'array'];
            $rules['avatar'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
            $rules['cv'] = ['nullable', 'file', 'mimes:pdf', 'max:5120'];
        }

        if ($this->user()->role === 'company') {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['siret'] = ['nullable', 'string', 'max:14'];
            $rules['website'] = ['nullable', 'url', 'max:255'];
            $rules['sector'] = ['nullable', 'string', 'max:255'];
            $rules['city'] = ['required', 'string', 'max:255'];
            $rules['logo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
        }

        return $rules;
    }
}