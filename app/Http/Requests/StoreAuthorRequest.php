<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAuthorRequest extends FormRequest
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
            'nama' => 'required|string',
            'bio' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'nama tidak boleh kosong',
            'nama.string' => 'nama harus berupa string',

            'bio.string' => 'bio harus berupa string'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error('Data tidak valid', 400, $validator->errors())
        );
    }
}
