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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'nama tidak boleh kosong',
            'name.string' => 'nama harus berupa string',
            'name.max' => 'nama maksimal 255 karakter',

            'email.required' => 'email tidak boleh kosong',
            'email.email' => 'email harus berformat email',
            'email.unique' => 'email sudah dipakai',

            'password.required' => 'password tidak boleh kosong',
            'password.min' => 'password minimal 8 karakter'
        ];
    }
}
