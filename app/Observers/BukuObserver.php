<?php

namespace App\Observers;

use App\Models\Buku;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BukuObserver
{
    /**
     * Handle the Buku "created" event.
     */
    public function created(Buku $buku): void
    {
        Log::info('Buku dibuat:', $buku->toArray());
    }

    public function creating(Buku $buku)
    {
        $buku->slug = Str::slug($buku->judul);
    }

    /**
     * Handle the Buku "updated" event.
     */
    public function updated(Buku $buku): void
    {
        Log::info('Buku diperbarui:', $buku->toArray());
    }

    public function updating(Buku $buku)
    {
        $buku->slug = Str::slug($buku->judul);
    }

    /**
     * Handle the Buku "deleted" event.
     */
    public function deleted(Buku $buku): void
    {
        Log::info('Buku dihapus:', $buku->toArray());
    }

    /**
     * Handle the Buku "restored" event.
     */
    public function restored(Buku $buku): void
    {
        Log::info('Buku berhasil dipulihkan:', $buku->toArray());
    }

    /**
     * Handle the Buku "force deleted" event.
     */
    public function forceDeleted(Buku $buku): void
    {
        Log::info('Buku dihapus paksa:', $buku->toArray());
    }
}
