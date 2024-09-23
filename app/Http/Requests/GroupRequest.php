<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'name' => 'required|min:4',
             
             'description' => 'required|min:4',
            //  'group_members' => 'required|array|min:2'
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Le nom du groupe est obligatoire est obligatoire',
            
            'description.required' => 'Ajouter une description au groupe',
            // 'group_members.min' => 'Au moins 2 personnes dans le groupe'
        ];
    }
}
