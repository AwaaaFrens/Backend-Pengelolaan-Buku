<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Contracts\Repositories\BukuRepository;
use App\Helpers\FileHelper;
use Illuminate\Http\UploadedFile;

class BukuService
{
    protected $bukuRepo;

    public function __construct(BukuRepository $bukuRepo)
    {
        $this->bukuRepo = $bukuRepo;
    }

    public function getAllBuku(?string $genre = null, ?string $author = null)
    {
        $data = $this->bukuRepo->get($genre, $author);

        $data->map(function ($buku) {
            if ($buku->cover_image) {
                $buku->cover_image_url = asset('storage/' . $buku->cover_image);
            }

            return $buku;
        });
        return $data;
    }

    public function getBukuById($id)
    {
        return $this->bukuRepo->show($id);
    }

    public function getBukuBySlug($slug)
    {
        return $this->bukuRepo->findBySlug($slug);
    }

    public function getJumlahBukuByGenre()
    {
        return $this->bukuRepo->jumlahBukuByGenre();
    }

    public function createBuku(array $data)
    {
        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            $imageInfo = FileHelper::upload($data['cover_image']);
            $data['cover_image'] = $imageInfo['path'];
            $data['cover_alt_text'] = $imageInfo['alt_text'];
            $data['cover_size'] = $imageInfo['size'];
        }

        return $this->bukuRepo->store($data);
    }

    public function updateBuku($id, array $data)
    {
        $buku = $this->bukuRepo->show($id);

        if (isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {
            if ($buku->cover_image) {
                FileHelper::delete($buku->cover_image);
            }

            $imageInfo = FileHelper::upload($data['cover_image']);
            $data['cover_image'] = $imageInfo['path'];
            $data['cover_alt_text'] = $imageInfo['alt_text'];
            $data['cover_size'] = $imageInfo['size'];
        }

        return $this->bukuRepo->update($id, $data);
    }

    public function deleteBuku($id)
    {
        $buku = $this->bukuRepo->show($id);

        if ($buku->cover_image) {
            FileHelper::delete($buku->cover_image);
        }

        return $this->bukuRepo->delete($id);
    }

    public function restoreBuku($id)
    {
        return $this->bukuRepo->restore($id);
    }

    public function searchBuku($search)
    {
        return $this->bukuRepo->searchBuku($search);
    }
}
