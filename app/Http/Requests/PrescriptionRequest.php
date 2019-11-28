<?php

namespace App\http\Requests;

use Illuminate\Foundation\http\FormRequest;

class prescriptionRequest extends FormRequest
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
            'patient_id' =>'',
            'hematologie' =>'',
            'hemostase' =>'',
            'biochimie' =>'',
            'hormonologie' =>'',
            'marqueurs' =>'',
            'bacteriologie' =>'',
            'spermiologie' =>'',
            'urines' =>'',
           'serologie' =>'',
           'examen' =>'',
        ];
    }
}
