<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ];
    }
    public function messages()
    {
        return [
            'email.exists' => 'Invalid Email ',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->sendErrors('Validation Error Has Occurred', $validator->errors()));
    }
}
