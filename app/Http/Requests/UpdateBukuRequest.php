<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBukuRequest extends FormRequest
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
            'judul' => 'string',
            'author_id' => 'exists:authors,id',
            'genre' => 'array',
            'genre.*' => 'string',
            'tahun_rilis' => 'digits:4|integer|min:1900|max:' . date('Y'),
            'isbn' => 'integer',
            'rating' => 'numeric|min:0|max:10'
        ];
    }

    public function messages(): array
    {
        return [
            'judul.string' => 'judul harus berupa teks',
            'author_id.exists' => 'id author tidak ada',

            'genre.array' => 'genre harus berupa array',
            'genre.*' => 'genre harus berupa teks',

            'tahun_rilis.digits' => 'tahun rilis harus terdiri dari 4 digit',
            'tahun_rilis.integer' => 'tahun rilis harus berupa angka',
            'tahun_rilis.min' => 'tahun rilis minimal dari tahun 1900',
            'tahun_rilis.max' => 'tahun rilis maksimal dari tahun' . date('Y'),

            'isbn.integer' => 'isbn harus berupa angka',

            'rating.numeric' => 'rating harus berupa angka',
            'rating.min' => 'rating minimal adalah 0',
            'rating.max' => 'rating maksimal adalah 10'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error('Data tidak valid', 400, $validator->errors())
        );
    }
}
