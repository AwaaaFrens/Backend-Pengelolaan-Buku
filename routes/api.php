<?php

use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('buku', BukuController::class);
