<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'votable_type' => ['required', 'string', 'in:App\Models\Question,App\Models\Answer'],
            'votable_id' => ['required', 'integer'],
            'value' => ['required', 'integer', 'in:1,-1'],
        ];
    }
}
