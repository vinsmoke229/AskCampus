<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
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
            'body' => ['required', 'string', 'min:10'],
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            'body.required' => 'Le contenu de la réponse est obligatoire.',
            'body.min' => 'La réponse doit contenir au moins 10 caractères.',
        ];
    }
}
