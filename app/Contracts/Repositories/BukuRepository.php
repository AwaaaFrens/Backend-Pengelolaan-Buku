<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BukuInterface;
use App\Models\Buku;

class BukuRepository extends BaseRepository implements BukuInterface
{
    public function __construct(Buku $buku) // mengisi $model tadi dengan instance Buku
    {
        $this->model = $buku; /* $menyimpan instance tadi ke BaseRepo */
    }

    public function get(): mixed // mixed berarti return type nya bisa berupa apa saja
    {
        return $this->model->query()->get(); // Buku::query()
    }

    public function store(array $data): mixed // array berarti data nya harus berupa array
    {
        return $this->model->query()->create($data);
    }

    public function show(int|string $id): mixed
    {
        return $this->model->query()->find($id);
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
}
