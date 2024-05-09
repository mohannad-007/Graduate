<?php

namespace App\Http\Requests\Student;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentRegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:student',
            'password' => 'required|min:8',
            'university_number'=>'required|exists:student'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationErrorResponse($validator->errors()));

    }
    public function messages() //OPTIONAL
    {
        return [
            'university_number.exists' => 'University Number is not correct'
        ];
    }
}
