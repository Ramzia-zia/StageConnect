<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'offer_id' => ['required', 'exists:offers,id'],
            'cover_letter_custom' => ['required', 'string', 'min:50'],
        ];
    }
}