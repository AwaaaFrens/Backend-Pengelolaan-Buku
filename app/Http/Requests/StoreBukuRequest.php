<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponseHelper;
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
            'author_id' => 'required|exists:authors,id',
            'genre' => 'required|array',
            'genre.*' => 'string',
            'tahun_rilis' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn' => 'required|integer|unique:bukus,isbn',
            'rating' => 'required|numeric|min:0|max:10',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'judul tidak boleh kosong',
            'judul.string' => 'judul harus berupa teks',

            'authors_id.required' => 'penulis tidak boleh kosong',
            'authors_id.exists' => 'id penulis tidak ada',

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
            'rating.max' => 'rating maksimal adalah 10',

            'cover_image.image' => 'File foto harus berupa gambar.',
            'cover_image.mimes' => 'Foto harus berformat jpeg, png, atau jpg.',
            'cover_image.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponseHelper::error('Data tidak valid', 400, $validator->errors())
        );
    }
}
