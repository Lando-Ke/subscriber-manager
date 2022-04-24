<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationErrorException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
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
            'title' => 'required|string',
            'type' => 'required|in:' . implode(',', config('subscriber.fields.allowed')),
            'value' => 'required|string',
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
