<?php

namespace App\Http\Requests\Diagnosis;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiagnosisLoginRequest extends FormRequest
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
            'email' => 'required|email|exists:diagnoses',
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
