<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegistationRequest extends FormRequest
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
            'email' => ['required','email','unique:users,email'],
            'user_name' => ['required','min:6','unique:users,user_name'],
            'phone' => ['required','numeric','min:7','unique:users,phone'],
            'role' => ['required'],
            'password' => ['required','confirmed']
        ];
    }
}
