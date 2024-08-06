<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserRequest extends FormRequest
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
        return User::rules();
    }


    public function messages(){
        return[
            'name' => config('global.PARAM_NAME_REQUIRED'),
            'cpf' => config('global.PARAM_CPF_REQUIRED'),
            'email' => config('global.PARAM_EMAIL_REQUIRED'),
            'password' => config('global.PARAM_PASSWORD_REQUIRED'),
        ];

    }

    public function attributes()
    {
        return [
            "name"=> "Nome",
            "cpf"=> "CPF",
            "email"=> "E-mail",
            "password"=> "Senha",
        ];
    }

}
