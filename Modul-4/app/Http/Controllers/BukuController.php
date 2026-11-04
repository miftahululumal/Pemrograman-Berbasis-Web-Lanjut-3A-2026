<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        // Mengambil semua data kategori untuk isi dropdown di form Blade
        $kategoris = Kategori::all();
        
        // Mengembalikan view halaman web buku/index.blade.php
        return view('buku.index', compact('kategoris'));
    }
}