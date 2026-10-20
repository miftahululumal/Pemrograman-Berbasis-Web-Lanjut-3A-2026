<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;

// Tambahkan as('api.') agar nama route API menjadi api.buku.index
Route::name('api.')->group(function () {
    Route::apiResource('buku', BukuController::class);
    Route::get('rekap/buku-per-kategori', [BukuController::class, 'bukuPerKategori']);
    Route::get('rekap/peminjaman-per-buku', [BukuController::class, 'peminjamanPerBuku']);
});