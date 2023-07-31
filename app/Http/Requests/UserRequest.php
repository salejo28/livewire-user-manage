<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => 'failed', 'errors' => $validator->errors()], 400));
    }

    public function messages()
    {
        return [
            'name.required' => 'The :attribute is required',
            'email.required' => 'The :attribute is required',
            'password.required' => 'The :attribute is required',
            'email.email' => 'Invalid :attribute',
            'email.unique' => 'The :attribute is already exists',
            'password.min' => 'The :attribute must be at least 8 characters long'
        ];
    }
}
