<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'address' => 'nullable|string',
            'phone' => 'sometimes|string',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'id_verification' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ];
    }
}
