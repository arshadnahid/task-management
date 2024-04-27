<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegistrationRequest extends FormRequest
{
    use ApiResponses;
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
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            'password' => 'required|confirmed|min:6',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->sendErrors('Validation Error Has Occurred', $validator->errors()));
    }
}
