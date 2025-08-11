<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum', 'role:admin|member'])->group(function () {
    Route::get('buku', [BukuController::class, 'index']);
    Route::get('buku/search', [BukuController::class, 'search']);
    Route::get('buku/{id}', [BukuController::class, 'show']);
    Route::get('buku/slug/{slug}', [BukuController::class, 'showBySlug']);
    Route::get('buku/statistik/genre', [BukuController::class, 'jumlahPerGenre']);

    Route::get('author', [AuthorController::class, 'index']);
    Route::get('author/{id}', [AuthorController::class, 'show']);
    Route::get('author/slug/{slug}', [AuthorController::class, 'showBySlug']);

    // untuk admin yah
    Route::middleware(['role:admin'])->group(function () {
        // buku
        Route::post('buku', [BukuController::class, 'store']);
        Route::put('buku/{buku}', [BukuController::class, 'update']);
        Route::delete('buku/{buku}', [BukuController::class, 'destroy']);
        Route::post('buku/{id}/restore', [BukuController::class, 'restore']);

        // author
        Route::post('author', [AuthorController::class, 'store']);
        Route::put('author/{author}', [AuthorController::class, 'update']);
        Route::delete('author/{author}', [AuthorController::class, 'destroy']);
        Route::post('author/{id}/restore', [AuthorController::class, 'restore']);

        // user
        Route::get('users/statistics', [UserController::class, 'statistics']);
        Route::get('users/search', [UserController::class, 'search']);
        Route::get('users/role/{role}', [UserController::class, 'getByRole']);

        // user umum
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{id}', [UserController::class, 'show']);
        Route::put('users/{id}', [UserController::class, 'update']);
        Route::delete('users/{id}', [UserController::class, 'destroy']);
        Route::put('users/{id}/promote', [UserController::class, 'promoteUser']);
        Route::put('users/{id}/demote', [UserController::class, 'demoteUser']);
        Route::patch('users/{id}/toggle-status', [UserController::class, 'toggleStatusUsers']);
    });
});
