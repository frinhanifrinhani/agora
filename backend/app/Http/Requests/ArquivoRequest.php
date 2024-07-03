<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Arquivo;

class ArquivoRequest extends FormRequest
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
        return Arquivo::rules();
    }

    public function messages(){
        return[
             'name' => config('global.PARAM_NAME_REQUIRED'),
             'file' => config('global.PARAM_FILE_REQUIRED'),
        ];

    }


}
