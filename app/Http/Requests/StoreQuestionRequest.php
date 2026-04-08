<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Autorisation de la requête
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:10', 'max:255'],
            'body' => ['required', 'string', 'min:20'],
            'tags' => ['nullable', 'array', 'max:5'],
            'tags.*' => ['exists:tags,id'],
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.min' => 'Le titre doit contenir au moins 10 caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'body.required' => 'Le contenu de la question est obligatoire.',
            'body.min' => 'Le contenu doit contenir au moins 20 caractères.',
            'tags.max' => 'Vous ne pouvez sélectionner que 5 tags maximum.',
            'tags.*.exists' => 'Un des tags sélectionnés n\'existe pas.',
        ];
    }
}
