<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator;


class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:64|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'passwordConfirm' => 'required|same:password',
        ];
    }

    public function messages(){

        return [

            'name.required' => 'Le nom est obligatoire',
            'name.min' => 'Au moins 3 caracteres pour le nom',
            'name.max' => 'Le maximum est de 25caracteres',
            'email.required' => 'E-mail obligatoire',
            'email.unique' => 'votre e-mail existe deja',
            'password.required' => 'Le mot de passe est obligatoire',
            'passwordConfirm.same' => 'La confirmation de mot de passe est echouee'
        ];

    }

    public function failedValidation (validator $validator){  
        throw new HttpResponseException(response()->json([
         'success' => false,
        'message' => 'Echec de validation',
         'data' => $validator->errors()
      ]));

    }

}
