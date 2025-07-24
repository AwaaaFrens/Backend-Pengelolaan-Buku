<?php

use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('buku', BukuController::class);
Route::get('buku/slug/{slug}', [BukuController::class, 'showBySlug']);
Route::post('buku/{id}/restore', [BukuController::class, 'restore']);