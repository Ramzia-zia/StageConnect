<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'salary' => ['nullable', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255'],
        ];
    }
}