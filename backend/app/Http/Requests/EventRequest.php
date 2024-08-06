<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;
use App\Traits\Sanitize;

class EventRequest extends FormRequest
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
        return Event::rules();
    }

    public function prepareForValidation():void
    {
        $data = $this->all();

        if(isset($data['phone'])){
            $data['phone'] = $this->removeSpecialCharacters($data['phone']);
        }

        if(isset($data['ddd'])){
            $data['ddd'] = $this->removeSpecialCharacters($data['ddd']);
        }

        $this->replace($data);
    }

    public function attributes()
    {
        return [
            "title"=> "Titulo",
            "body"=> "Evento",
            "start_date"=> "Data início",
            "start_time"=> "Hora início",
            "end_date"=> "Data fim",
            "end_time"=> "Hora fim",
            "organizer"=> "Organizador",
            "address"=> "Endereço",
        ];
    }

}
