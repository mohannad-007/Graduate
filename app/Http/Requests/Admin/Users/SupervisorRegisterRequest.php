<?php

namespace App\Http\Requests\Admin\Users;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SupervisorRegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:supervisors',
            'password' => 'required|min:8',
            'gender' => 'in:male,female,other',
            'type' => 'in:master,doctor',
            'student_id'=>'numeric',
            'first_name'=>'string',
            'last_name'=>'string',
            'image_av'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
