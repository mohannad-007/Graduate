<?php

namespace App\Http\Requests\Admin\Users;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SectionRegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:sections',
            'password' => 'required|min:8',
            'name' => 'required|string|unique:sections',
            'details' => 'required|string',
        ];
    }
    public function prepareForValidation(): void
    {
        if ($this->hasFile('image_av')) {
            $file = $this->file('image_av');
            $filePath = $file->move(public_path('/images'), $file->getClientOriginalName());
            $url = url('images/' . $file->getClientOriginalName());
            $this->merge(['section_image' => $url]);
        }
        $this->request->remove('image_av');

    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validationErrorResponse($validator->errors()));

    }
}
