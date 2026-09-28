<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    private function dataBuku()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Belajar Laravel Framework',
                'penulis' => 'Yuniar Supardi',
                'tahun' => 2023,
                'kategori' => 'Pemrograman',
                'cover' => 'https://image.gramedia.net/rs:fit:0:0/f:webp/plain/https://cdn.gramedia.com/uploads/product-metas/se-aol-k1x.jpg?w=500',
            ],
            [
                'id' => 2,
                'judul' => 'Belajar PHP Modern',
                'penulis' => 'Adang wihanda',
                'tahun' => 2022,
                'kategori' => 'Pemrograman',
                'cover' => 'https://minhajpustaka.id/wp-content/uploads/2025/05/COVER.jpg?w=500',
            ],
            [
                'id' => 3,
                'judul' => 'Dasar-Dasar Web Development',
                'penulis' => 'Kristianto Hariyadi',
                'tahun' => 2024,
                'kategori' => 'Web Development',
                'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHb9tek-MqEDAXbvVzz18gWBjVg6P1nL9-9L1H2g-YGS9SMxY0ELUj53r2&s=10?w=500',
            ],
            [
                'id' => 4,
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'M.A Saelan',
                'tahun' => 2021,
                'kategori' => 'Informatika',
                'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTEGbmoVqZObYvJglL8yrSBSeuniVxoUB0qCMWv5hGaAEwm6C2jw0WaieQ&s=10?w=500',
            ],
            [
                'id' => 5,
                'judul' => 'Dasar Dasar SQL dan BDR',
                'penulis' => 'Andharini dwi cahyani',
                'tahun' => 2023,
                'kategori' => 'Database',
                'cover' => 'https://i0.wp.com/bintangpustaka.com/wp-content/uploads/2024/10/DASAR-DASAR-SQL-DAN-BASIS-DATA_FRONTCOVER.jpeg?fit=692%2C1080&ssl=1?w=500',
            ],
        ];
    }

    public function index()
    {
        $buku = $this->dataBuku();

        return view('buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = $this->dataBuku();

        $dataBuku = null;

        foreach ($buku as $item) {
            if ($item['id'] == $id) {
                $dataBuku = $item;
                break;
            }
        }

        return view('buku.show', compact('dataBuku'));
    }
}