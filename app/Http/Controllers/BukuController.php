<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Services\BukuService;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    protected $bukuService;

    public function __construct(BukuService $bukuService)
    {
        $this->bukuService = $bukuService;
    }

    public function index(Request $request)
    {
        $genre = $request->query('genre');
        $author = $request->query('author');

        $buku = $this->bukuService->getAllBuku($genre, $author);

        if ($buku->isEmpty()) {
            return ApiResponse::error('Data tidak ditemukan', 404);
        }

        return ApiResponse::success($buku, 'Daftar Buku');
    }

    public function show($id)
    {
        $buku = $this->bukuService->getBukuById($id);

        if (!$buku) {
            return ApiResponse::error('Buku tidak ditemukan', 404);
        }

        return ApiResponse::success($buku, 'Data buku');
    }

    public function showBySlug($slug)
    {
        $buku = $this->bukuService->getBukuBySlug($slug);

        if (!$buku) {
            return ApiResponse::error('Buku tidak ditemukan', 404);
        }

        return ApiResponse::success($buku, 'Data buku');
    }

    public function jumlahPerGenre()
    {
        $data = $this->bukuService->getJumlahBukuByGenre();

        return ApiResponse::success($data, 'Jumlah Buku per Genre');
    }

    public function store(StoreBukuRequest $request)
    {
        $buku = $this->bukuService->createBuku($request->validated());

        if (!$buku) {
            return ApiResponse::error('Gagal menambahkan data', 400);
        }

        return ApiResponse::success($buku, 'Buku berhasil ditambahkan');
    }

    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = $this->bukuService->updateBuku($id, $request->validated());

        if (!$buku) {
            return ApiResponse::error('Gagal memperbarui data', 400);
        }

        return ApiResponse::success($buku, 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $buku = $this->bukuService->deleteBuku($id);

        if (!$buku) {
            return ApiResponse::error('Data telah dihapus', 404);
        }

        return ApiResponse::success(null, 'Buku berhasil dihapus');
    }

    public function restore($id)
    {
        $buku = $this->bukuService->restoreBuku($id);

        if (!$buku) {
            return ApiResponse::error('Gagal mengembalikan data', 400);
        }

        return ApiResponse::success($buku, 'Buku berhasil dikembalikan');
    }
}
