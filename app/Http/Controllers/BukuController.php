<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Helpers\PaginateHelper;
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
            return ApiResponseHelper::error('Data tidak ditemukan', 404);
        }

        return ApiResponseHelper::success(
            PaginateHelper::format($buku), 
            'Daftar Buku');
    }

    public function show($id)
    {
        $buku = $this->bukuService->getBukuById($id);

        if (!$buku) {
            return ApiResponseHelper::error('Buku tidak ditemukan', 404);
        }

        return ApiResponseHelper::success($buku, 'Data buku');
    }

    public function showBySlug($slug)
    {
        $buku = $this->bukuService->getBukuBySlug($slug);

        if (!$buku) {
            return ApiResponseHelper::error('Buku tidak ditemukan', 404);
        }

        return ApiResponseHelper::success($buku, 'Data buku');
    }

    public function jumlahPerGenre()
    {
        $data = $this->bukuService->getJumlahBukuByGenre();

        return ApiResponseHelper::success($data, 'Jumlah Buku per Genre');
    }

    public function store(StoreBukuRequest $request)
    {
        $buku = $this->bukuService->createBuku($request->validated());

        if (!$buku) {
            return ApiResponseHelper::error('Gagal menambahkan data', 400);
        }

        return ApiResponseHelper::success($buku, 'Buku berhasil ditambahkan');
    }

    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = $this->bukuService->updateBuku($id, $request->validated());

        if (!$buku) {
            return ApiResponseHelper::error('Gagal memperbarui data', 400);
        }

        return ApiResponseHelper::success($buku, 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $buku = $this->bukuService->deleteBuku($id);

        if (!$buku) {
            return ApiResponseHelper::error('Data telah dihapus', 404);
        }

        return ApiResponseHelper::success(null, 'Buku berhasil dihapus');
    }

    public function restore($id)
    {
        $buku = $this->bukuService->restoreBuku($id);

        if (!$buku) {
            return ApiResponseHelper::error('Gagal mengembalikan data', 400);
        }

        return ApiResponseHelper::success($buku, 'Buku berhasil dikembalikan');
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');
        $buku = $this->bukuService->searchBuku($search);
        $formattedBuku = PaginateHelper::format($buku);

        return ApiResponseHelper::success($formattedBuku, 'Hasil pencarian buku');
    }
}
