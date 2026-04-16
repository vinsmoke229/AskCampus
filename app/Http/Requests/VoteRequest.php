<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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
            'votable_type' => ['required', 'string', 'in:App\Models\Question,App\Models\Answer'],
            'votable_id' => ['required', 'integer', 'exists:' . $this->getTableName() . ',id'],
            'value' => ['required', 'integer', 'in:1,-1'],
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            'votable_type.required' => 'Le type de contenu est requis.',
            'votable_type.in' => 'Type de contenu invalide.',
            'votable_id.required' => 'L\'identifiant du contenu est requis.',
            'votable_id.exists' => 'Le contenu n\'existe pas.',
            'value.required' => 'La valeur du vote est requise.',
            'value.in' => 'La valeur du vote doit être +1 ou -1.',
        ];
    }

    /**
     * Récupère le nom de la table en fonction du type
     */
    private function getTableName(): string
    {
        return $this->votable_type === 'App\Models\Question' ? 'questions' : 'answers';
    }
}
