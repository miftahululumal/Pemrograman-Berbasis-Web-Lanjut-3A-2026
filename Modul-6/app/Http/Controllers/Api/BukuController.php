<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Resources\BukuResource; // <--- 1. TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BukuController extends Controller
{
    /**
     * Soal 3.a & Modul 4 Soal 1: Menampilkan daftar buku menggunakan BukuResource
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans')
            ->latest('id');

        // Filter pencarian
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        $bukus = $query->get();

        // <--- 2. UBAH DI SINI: Bungkus data menggunakan BukuResource
        return BukuResource::collection($bukus);
    }

    /**
     * Soal 3.b: Menyimpan data buku baru (HTTP 201)
     */
    public function store(StoreBukuRequest $request): JsonResponse
    {
        $buku = Buku::create($request->validated());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data'    => new BukuResource($buku->load('kategori')),
        ], 201);
    }

    /**
     * Soal 3.c & Modul 4 Soal 1: Menampilkan detail satu buku menggunakan BukuResource
     */
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        // <--- 3. UBAH DI SINI: Gunakan new BukuResource
        return new BukuResource($buku);
    }

    /**
     * Soal 3.d: Memperbarui data buku (HTTP 200 / 404)
     */
    public function update(UpdateBukuRequest $request, $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $buku->update($request->validated());

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data'    => new BukuResource($buku->load('kategori')),
        ], 200);
    }

    // Saol 2 3A 
    public function destroy($id): JsonResponse
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ], 200);
    }

    /**
     * Soal 7.a: Rekap jumlah buku per kategori
     */
    public function bukuPerKategori(): JsonResponse
    {
        $rekap = Kategori::withCount('bukus')->get();

        return response()->json([
            'data' => $rekap
        ], 200);
    }

    /**
     * Soal 7.b: Rekap total peminjaman per buku
     */
    public function peminjamanPerBuku(): JsonResponse
    {
        $rekap = Buku::withCount('peminjamans')->get();

        return response()->json([
            'data' => $rekap
        ], 200);
    }


    public function cariBuku(\Illuminate\Http\Request $request)
    {
        $judul = $request->query('judul');
        
        // Aman dari SQL Injection (Parameter Binding menggunakan placeholder ?)
        $bukus = \DB::select("SELECT * FROM bukus WHERE judul = ?", [$judul]);
        
        return response()->json($bukus);
    }
}