<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'publication_type' => [
                'required',
                'in:journal_article,conference_paper,book,book_chapter,technical_report,policy_brief,thesis,dataset,other',
            ],

            'journal' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (now()->year + 1)],
            'volume' => ['nullable', 'string', 'max:255'],
            'issue' => ['nullable', 'string', 'max:255'],
            'pages' => ['nullable', 'string', 'max:255'],
            'doi' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'abstract' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],

            'people' => ['nullable', 'array'],

            'people.*.person_id' => [
                'required',
                'integer',
                'exists:people,id',
                'distinct',
            ],

            'people.*.author_order' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
    }
}
