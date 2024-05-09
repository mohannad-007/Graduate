<?php

namespace App\Http\Requests\Patient;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class PatientProfileRequest extends FormRequest
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
            'email'=>'email|unique:patient'
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
