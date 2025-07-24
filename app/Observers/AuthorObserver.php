<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthorObserver
{
    /**
     * Handle the Author "created" event.
     */
    public function created(Author $author): void
    {
        Log::info('Author ditambahkan:', $author->toArray());
    }

    public function creating(Author $author)
    {
        $author->slug = Str::slug($author->nama);
    }

    /**
     * Handle the Author "updated" event.
     */
    public function updated(Author $author): void
    {
        Log::info('Author diperbarui:', $author->toArray());
    }

    public function updating(Author $author)
    {
        $author->slug = Str::slug($author->nama);
    }

    /**
     * Handle the Author "deleted" event.
     */
    public function deleted(Author $author): void
    {
        Log::info('Author dihapus:', $author->toArray());
    }

    /**
     * Handle the Author "restored" event.
     */
    public function restored(Author $author): void
    {
        Log::info('Author dikembalikan:', $author->toArray());
    }

    /**
     * Handle the Author "force deleted" event.
     */
    public function forceDeleted(Author $author): void
    {
        Log::info('Author dipaksa hapus:', $author->toArray());
    }
}
