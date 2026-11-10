<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();

        $totalPengguna = User::count();

        $totalPeminjaman = Peminjaman::count();

        $totalPengembalian = Peminjaman::whereNotNull(
            'tanggal_dikembalikan'
        )->count();

        $laporanPeminjaman = Peminjaman::with([
            'anggota',
            'buku',
            'pemroses'
        ])->latest()->get();

        return view('laporan.index', compact(
            'totalBuku',
            'totalPengguna',
            'totalPeminjaman',
            'totalPengembalian',
            'laporanPeminjaman'
        ));
    }
}