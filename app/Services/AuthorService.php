<?php

namespace App\Services;

use App\Contracts\Repositories\AuthorRepository;

class AuthorService
{
    protected $authorRepo;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepo = $authorRepository;
    }

    public function getAllAuthor()
    {
        return $this->authorRepo->get();
    }

    public function getAuthorById($id)
    {
        return $this->authorRepo->show($id);
    }

    public function getAuthorBySlug($slug)
    {
        return $this->authorRepo->findBySlug($slug);
    }

    public function createAuthor(array $data)
    {
        return $this->authorRepo->store($data);
    }

    public function updateAuthor($id, array $data)
    {
        return $this->authorRepo->update($id, $data);
    }

    public function deleteAuthor($id)
    {
        return $this->authorRepo->delete($id);
    }

    public function restoreAuthor($id)
    {
        return $this->authorRepo->restore($id);
    }
}
