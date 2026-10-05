<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BukuController extends Controller
{
    private function dataBuku()
    {
        return Buku::with('kategori')
            ->get()
            ->map(function ($buku) {
                return [
                    'id' => $buku->id,
                    'judul' => $buku->judul,
                    'penulis' => $buku->penulis,
                    'tahun' => $buku->tahun_terbit,
                    'kategori' => $buku->kategori->nama,
                    'cover' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500',
                ];
            })
            ->toArray();
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