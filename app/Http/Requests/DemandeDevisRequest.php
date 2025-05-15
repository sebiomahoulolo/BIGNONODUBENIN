<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemandeDevisRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'material' => 'required|string',
            'category_id' => 'required|integer',
            'indicatif' => 'required|string',
            'phone' => 'required|string',
            'city' => 'required|string',
            'delai_livraison' => 'required|integer',
            'description' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.email' => 'Le format de l’e-mail est invalide.',
            'material.required' => 'Le matériel est requis.',
            'category_id.required' => 'Le produit est requis.',
            'indicatif.required' => 'L’indicatif est requis.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            'city.required' => 'La ville est requise.',
            'delai_livraison.required' => 'Le délai de livraison est requis.',
            'delai_livraison.integer' => 'Le délai de livraison doit être un nombre.',
            'description.required' => 'La description est obligatoire.',
        ];
    }
}
