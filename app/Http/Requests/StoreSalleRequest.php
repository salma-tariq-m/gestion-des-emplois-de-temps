<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSalleRequest extends FormRequest
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
        $id = $this->route('salle') ? $this->route('salle')->id : null;
        return [
            'code' => 'required|string|max:20|unique:salles,code,' . $id,
            'capacite' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code de la salle est obligatoire.',
            'code.unique' => 'Ce code de salle existe déjà.',
            'capacite.integer' => 'La capacité doit être un nombre entier.',
            'capacite.min' => 'La capacité doit être au moins de 1.',
        ];
    }
}
