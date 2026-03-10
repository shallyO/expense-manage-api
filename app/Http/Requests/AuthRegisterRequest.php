<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',

            // user must provide email OR phone
            'email' => 'nullable|email|unique:users,email|required_without:phone_number',
            'phone_number' => 'nullable|string|unique:users,phone_number|required_without:email',

            'password' => 'required|min:6|confirmed',
        ];
    }
}
