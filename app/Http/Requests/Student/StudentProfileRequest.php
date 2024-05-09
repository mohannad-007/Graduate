<?php

namespace App\Http\Requests\Student;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentProfileRequest extends FormRequest
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
            'birthday' => 'date',
            'gender' => 'in:male,female,other',
            'year' => 'in:1,2,3,4,5',
            'diagnosis' => 'in:0,1',
            'email'=>'email|unique:student'

        ];
    }
    public function prepareForValidation(): void
    {
        if ($this->hasFile('image_av')) {
            $file = $this->file('image_av');
            $filePath = $file->move(public_path('/images'), $file->getClientOriginalName());
            $url = url('images/' . $file->getClientOriginalName());
            $this->merge(['image' => $url]);
        }
        $this->request->remove('image_av');

    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationErrorResponse($validator->errors()));

    }
}
