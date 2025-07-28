<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('buku', BukuController::class);
Route::get('buku/slug/{slug}', [BukuController::class, 'showBySlug']);
Route::get('buku/statistik/genre', [BukuController::class, 'jumlahPerGenre']);
Route::post('buku/{id}/restore', [BukuController::class, 'restore']);

Route::apiResource('author', AuthorController::class);
Route::get('author/slug/{slug}', [AuthorController::class, 'showBySlug']);
Route::post('author/{id}/restore', [AuthorController::class, 'restore']);