<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeachingMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'ppt_url' => [
                'required',
                'url',
                'starts_with:https://drive.google.com/',
            ],
        ];
    }
}
