<?php

namespace App\Http\Requests;

use App\Rules\IsInServicePeriod;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'moment' => $this->date . ' ' . $this->time,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //dd($this->all());
        return [
            'user_id' => ['nullable', 'numeric','exist:users'],
            'service_id' => ['required', 'numeric', 'exists:service_settings,id'],
            //rule to see if moment is in service period
            //Vérifier qu'il reste de la place
            'moment' => ['required', 'string', 'date'],
            'email' => ['required', 'email:rfc,dns'],
            'mobile' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'min:2','max:40'],
            'firstname' => ['required', 'string', 'min:2', 'max:40'],
            'comments' => ['nullable', 'string'],
        ];
    }
}
