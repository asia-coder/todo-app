<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\V1\Auth\RegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|confirmed|min:8|max:255',
            'password_confirmation' => 'required|string|min:8|max:255',
        ];
    }

    public function payload(): RegisterDTO
    {
        return new RegisterDTO(
            name: $this->input('name'),
            email: $this->input('email'),
            password: $this->input('password'),
        );
    }
}
