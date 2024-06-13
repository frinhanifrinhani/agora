<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\News;
use App\Traits\Sanitize;

class NewsRequest extends FormRequest
{
    use Sanitize;

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
        return News::rules();
    }

    public function messages(){
        return[
            'title' => config('global.PARAM_TITLE_REQUIRED'),
            'title' => config('global.PARAM_TITLE_MAX'),
            'news' => config('global.PARAM_NEWS_REQUIRED'),
        ];

    }


}
