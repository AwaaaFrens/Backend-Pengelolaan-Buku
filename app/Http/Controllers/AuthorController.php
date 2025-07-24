<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $authorServ;

    public function __construct(AuthorService $authorService)
    {
        $this->authorServ = $authorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $author = $this->authorServ->getAllAuthor();

        if (!$author) {
            return ApiResponse::error('Data tidak ada', 404);
        }

        return ApiResponse::success($author, 'Daftar Author');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = $this->authorServ->createAuthor($request->validated());

        if (!$author) {
            return ApiResponse::error('Gagal menambah data', 400);
        }

        return ApiResponse::success($author, 'Data Author');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $author = $this->authorServ->getAuthorById($id);

        if (!$author) {
            return ApiResponse::error('Data tidak ditemukan', 404);
        }

        return ApiResponse::success($author, 'Data Author');
    }

    public function showBySlug($slug)
    {
        $author = $this->authorServ->getAuthorBySlug($slug);

        if (!$author) {
            return ApiResponse::error('Data tidak ditemukan', 404);
        }

        return ApiResponse::success($author, 'Data Author');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAuthorRequest $request, $id)
    {
        $author = $this->authorServ->updateAuthor($id, $request->validated());
        
        if (!$author) {
            return ApiResponse::error('Gagal memperbarui data', 400);
        }

        return ApiResponse::success($author, 'Data Author');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $author = $this->authorServ->deleteAuthor($id);

        if (!$author) {
            return ApiResponse::error('Gagal menghapus data', 400);
        }

        return ApiResponse::success(null, 'Berhasil menghapus data');
    }

    public function restore($id)
    {
        $author = $this->authorServ->restoreAuthor($id);

        if (!$author) {
            return ApiResponse::error('Gagal mengembalikan data', 400);
        }

        return ApiResponse::success(null, 'Berhasil mengembalikan data');
    }
}
