<?php

namespace App\Services;

use App\Contracts\Repositories\BukuRepository;

class BukuService
{
    protected $bukuRepo;

    public function __construct(BukuRepository $bukuRepo)
    {
        $this->bukuRepo = $bukuRepo;
    }

    public function getAllBuku(?string $genre = null, ?string $author = null)
    {
        return $this->bukuRepo->get($genre, $author);
    }

    public function getBukuById($id)
    {
        return $this->bukuRepo->show($id);
    }

    public function getBukuBySlug($slug)
    {
        return $this->bukuRepo->findBySlug($slug);
    }

    public function createBuku(array $data)
    {
        return $this->bukuRepo->store($data);
    }

    public function updateBuku($id, array $data)
    {
        return $this->bukuRepo->update($id, $data);
    }

    public function deleteBuku($id)
    {
        return $this->bukuRepo->delete($id);
    }

    public function restoreBuku($id)
    {
        return $this->bukuRepo->restore($id);
    }
}
