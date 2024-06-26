<?php

namespace App\Http\Requests\Task;

use App\Rules\ValidateCategoriesId;
use App\Traits\ApiResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
            'due_date' => 'nullable|date',
            'tags' => 'nullable',
            'category_ids' => ['nullable',new ValidateCategoriesId()],
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->sendErrors('Validation Error Has Occurred', $validator->errors()));
    }
}
