<?php

namespace App\Http\Requests\Validation;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'phone'     => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'
            ],
            'role'      => 'required',
            'branch_id' => 'required|integer',
            'status'    => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'      => 'Name is required',
            'email.required'     => 'Email is required',
            'email.unique'       => 'Email already exists',
            'phone.required'     => 'Phone is required',
            'phone.unique'       => 'Phone already exists',
            'password.required'  => 'Password is required',
            'password.min'       => 'Password must be at least 6 characters',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character',

            'role.required'      => 'Role is required',
            'role.in'            => 'Role must be admin or user',
            'branch_id.required' => 'Branch is required',
            'branch_id.integer'  => 'Branch ID must be a number',
            'status.required'    => 'Status is required',
            'status.in'          => 'Status must be active or inactive',

        ];
    }
}
