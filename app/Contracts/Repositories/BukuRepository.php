<?php

namespace App\Contracts\Repositories;

use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use App\Contracts\Interfaces\BukuInterface;

class BukuRepository extends BaseRepository implements BukuInterface
{
    public function __construct(Buku $buku) // mengisi $model tadi dengan instance Buku
    {
        $this->model = $buku; /* $menyimpan instance tadi ke BaseRepo */
    }

    public function get(?string $genre = null, ?string $author = null): mixed // mixed berarti return type nya bisa berupa apa saja
    {
        $query = $this->model->query();

        if ($genre) {
            $query->where('genre', 'like', "%{$genre}%");
        }

        if ($author) {
            $query->where('author', 'like', "%{$author}%");
        }

        return $query->get();
    }

    public function store(array $data): mixed // array berarti data nya harus berupa array
    {
        return $this->model->query()->create($data);
    }

    public function show(int|string $id): mixed
    {
        return $this->model->query()->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->query()->where('slug', $slug)->first();
    }

    public function update(int|string $id, array $data): mixed
    {
        $buku = $this->model->query()->find($id);
        $buku->update($data);
        return $buku->refresh();
    }

    public function delete(int|string $id): mixed
    {
        return $this->model->query()->find($id)->delete();
    }

    public function restore($id)
    {
        return $this->model->withTrashed()->find($id)->restore();
    }

    public function jumlahBukuByGenre()
    {
        return Buku::all(['genre'])
            ->flatMap(fn($buku) => $buku->genre ?: []) // ambil genre tiap buku terus dijadiin horizontal ?: artinya kalo genre null kembaliin array kosong
            ->countBy() // hitung berapa kali item muncul
            ->map(fn($jumlah, $genre) => [ // transform tiap item dengan format genre dan jumlah
                'genre' => $genre, // kembaliin data genre dengan jumlahnya berapa
                'jumlah' => $jumlah
            ])
            ->values();
    }
}
