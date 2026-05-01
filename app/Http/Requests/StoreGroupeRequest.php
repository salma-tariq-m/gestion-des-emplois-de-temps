<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        $id = $this->route('groupe') ? $this->route('groupe')->id : null;
        return [
            'code' => 'required|string|max:50|unique:groupes,code,' . $id,
            'filiere_id' => 'required|exists:filieres,id',
            'annee' => 'required|integer|in:1,2',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code du groupe est obligatoire.',
            'code.unique' => 'Ce code de groupe existe déjà.',
            'filiere_id.required' => 'La filière est obligatoire.',
            'filiere_id.exists' => 'La filière sélectionnée n\'existe pas.',
            'annee.required' => 'L\'année est obligatoire.',
            'annee.in' => 'L\'année doit être 1 ou 2.',
        ];
    }
}
