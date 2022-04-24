<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationErrorException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SubscriberRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email_address' => ['required', 'email'],
            'state_id' => ['required', 'int'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $errorMessage = '';
        foreach ($errors->messages() as $error){
            $errorMessage = $errorMessage.' '. $error[0];
        }

        throw new ValidationErrorException($errorMessage);
    }
}
