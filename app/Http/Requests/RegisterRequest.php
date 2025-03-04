<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'fullname' => 'required|string|min:5|max:255',
            'email' => 'required|email',
            'password' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'fullname' => 'El campo fullname es requerido',
            'fullname.string' => 'El campo fullname debe ser un string',
            'fullname.min' => 'El campo fullname debe tener al menos 5 caracteres',
            'fullname.max' => 'El campo fullname no debe exceder los 255 caracteres',
            'email.required' => 'El campo email es requerido',
            'email.email' => 'El campo email debe ser un email válido',
            'password.required' => 'El campo password es requerido',
            'password.string' => 'El campo password debe ser un string',
            'password.max' => 'El campo password no debe exceder los 255 caracteres',
        ];
    }

}
