<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\V1\Auth\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function payload(): LoginDTO
    {
        return new LoginDTO(
            email: $this->input('email'),
            password: $this->input('password'),
        );
    }
}
