<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AuthorInterface;
use App\Models\Author;

class AuthorRepository extends BaseRepository implements AuthorInterface
{
    public function __construct(Author $Author)
    {
        $this->model = $Author;
    }

    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()->with('bukus')->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->query()->with('bukus')->where('slug', $slug)->first();
    }

    public function update(mixed $id, array $data): mixed
    {
        $author = $this->model->find($id);
        $author->update($data);
        return $author->refresh();
    }

    public function delete(mixed $id): mixed
    {
        return $this->model->query()->find($id)->delete();
    }

    public function restore($id)
    {
        return $this->model->withTrashed()->find($id)->restore();
    }
}
