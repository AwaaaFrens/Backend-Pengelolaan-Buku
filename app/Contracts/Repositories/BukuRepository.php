<?php

namespace App\Contracts\Repositories;

use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use App\Contracts\Interfaces\BukuInterface;
use Illuminate\Support\Facades\Cache;

class BukuRepository extends BaseRepository implements BukuInterface
{
    public function __construct(Buku $buku) // mengisi $model tadi dengan instance Buku
    {
        $this->model = $buku; /* $menyimpan instance tadi ke BaseRepo */
    }

    public function get(?string $genre = null, ?string $author = null): mixed // mixed berarti return type nya bisa berupa apa saja
    {
        $query = $this->model->with('authors:id,nama');

        if ($genre) {
            $query->whereJsonContains('genre', $genre);
        }

        if ($author) {
            $query->whereHas('author', function ($q) use ($author) {
                $q->where('nama', 'like', "%{$author}%");
            });
        }

        return $query->get();
    }

    public function store(array $data): mixed // array berarti data nya harus berupa array
    {
        $result = $this->model->create($data);

        Cache::forget('jumlah_buku_by_genre');

        return $result;
    }

    public function show(int|string $id): mixed
    {
        return $this->model->with('authors:id,nama')->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->with('authors:id,nama')->where('slug', $slug)->first();
    }

    public function update(int|string $id, array $data): mixed
    {
        $buku = $this->model->query()->find($id);
        $buku->update($data);
        if (isset($data['genre'])) {
            Cache::forget('jumlah_buku_by_genre');
        }

        return $buku->load('authors:id,nama');
    }

    public function delete(int|string $id): mixed
    {
        $result = $this->model->find($id)->delete();

        Cache::forget('jumlah_buku_by_genre');

        return $result;
    }

    public function restore($id)
    {
        $result = $this->model->withTrashed()->find($id)->restore();

        Cache::forget('jumlah_buku_by_genre');

        return $result;
    }

    public function jumlahBukuByGenre()
    {
        return Cache::remember('jumlah_buku_by_genre', 300, function () {
            $bukus = $this->model->whereNotNull('genre')->get(['genre']);

            $genreCount = [];

            foreach ($bukus as $buku) {
                $genres = $buku->genre;

                if (is_array($genres)) {
                    foreach ($genres as $genre) {
                        if (!empty($genre)) {
                            if (isset($genreCount[$genre])) {
                                $genreCount[$genre]++;
                            } else {
                                $genreCount[$genre] = 1;
                            }
                        }
                    }
                }
            }

            $result = [];
            foreach ($genreCount as $genre => $jumlah) {
                $result[] = [
                    'genre' => $genre,
                    'jumlah' => $jumlah
                ];
            }

            return collect($result);
        });
    }

    public function searchBuku(string $search)
    {
        return $this->model
            ->with('author:id,nama')
            ->where('judul', 'like', "%{$search}%")
            ->select(['id', 'judul', 'author_id', 'slug'])
            ->limit(50)
            ->get();
    }
}
