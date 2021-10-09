<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceSettingIndexRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year' => ['nullable', 'required_with:month,day','digits:4','integer','min:1900', 'max:'.(\date('Y')+1)],
            'month' => ['nullable','required_with:year,day','digits_between:1,2','integer','min:1', 'max:12'],
            'day' => ['nullable','required_with:month,year', 'digits_between:1,2','integer','min:1', 'max:31'],
        ];
    }
}
