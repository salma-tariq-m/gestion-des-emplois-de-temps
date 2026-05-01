<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormateurRequest extends FormRequest
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
        $id = $this->route('formateur') ? $this->route('formateur')->id : null;
        return [
            'matricule' => 'required|string|max:20|unique:formateurs,matricule,' . $id,
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:formateurs,email,' . $id,
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'matricule.required' => 'Le matricule est obligatoire.',
            'matricule.unique' => 'Ce matricule existe déjà.',
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Format d\'email invalide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'specialite.required' => 'La spécialité est obligatoire.',
        ];
    }
}
