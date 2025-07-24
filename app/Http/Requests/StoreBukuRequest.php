<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBukuRequest extends FormRequest
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
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'genre' => 'required|array',
            'genre.*' => 'string',
            'tahun_rilis' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn' => 'required|integer|unique:bukus,isbn',
            'rating' => 'required|numeric|min:0|max:10'
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'judul tidak boleh kosong',
            'judul.string' => 'judul harus berupa teks',

            'penulis.required' => 'penulis tidak boleh kosong',
            'penulis.string' => 'penulis harus berupa teks',

            'genre.required' => 'genre tidak boleh kosong',
            'genre.array' => 'genre harus berupa array',
            'genre.*' => 'genre harus berupa teks',

            'tahun_rilis.required' => 'tahun rilis tidak boleh kosong',
            'tahun_rilis.digits' => 'tahun rilis harus terdiri dari 4 digit',
            'tahun_rilis.integer' => 'tahun rilis harus berupa angka',
            'tahun_rilis.min' => 'tahun rilis minimal dari tahun 1900',
            'tahun_rilis.max' => 'tahun rilis maksimal dari tahun' . date('Y'),

            'isbn.required' => 'isbn tidak boleh kosong',
            'isbn.integer' => 'isbn harus berupa angka',
            'isbn.unique' => 'isbn sudah digunakan',

            'rating.required' => 'rating tidak boleh kosong',
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
