<?php

namespace App\Http\Requests\Patient;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PatientLoginRequest extends FormRequest
{
    use RespondsWithHttpStatus;
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
            'email' => 'required|email|exists:patient',
            'password' => 'required|min:8'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationErrorResponse($validator->errors()));

    }
    public function messages() //OPTIONAL
    {
        return [
            'email.exists' => 'Email is not correct'
        ];
    }
}
