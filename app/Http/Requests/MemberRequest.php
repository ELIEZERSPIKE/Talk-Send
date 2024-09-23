<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name' => 'required|unique:groupe_members',
            'email' => 'required', 
        ];
    }

    public function messages(){

        return [

            'name.required' => 'Le nom est obligatoire',
            'name.string' => 'Le nom est une chaine de caractere ',
            'name.max' => 'Le maximum est de 60 caracteres',
            'email.required' => 'E-mail obligatoire',
            // 'email.unique' => 'Cet e-mail existe deja',
            
        ];

    }

}
