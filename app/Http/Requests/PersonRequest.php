<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'position' => ['nullable', 'string', 'max:255'],
            'short_bio' => ['nullable', 'string', 'max:1000'],
            'bio' => ['nullable', 'string'],

            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'scopus' => ['nullable', 'url', 'max:255'],
            'google_scholar' => ['nullable', 'url', 'max:255'],
            'orcid' => ['nullable', 'url', 'max:255'],
            'sinta' => ['nullable', 'url', 'max:255'],

            'education' => ['nullable', 'string'],
            'research_interests' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
