<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BukuController extends Controller
{
    /**
     * Soal 3.a: Menampilkan daftar buku (HTTP 200)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Buku::with('kategori')
            ->withCount('peminjamans')
            ->latest('id'); // Urutkan data terbaru lebih dulu

        // Pencarian berdasarkan judul atau penulis
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        // Filter berdasarkan kategori_id
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan tahun_terbit
        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        // Pagination 10 data per halaman + query string terbawa saat pindah halaman
        $bukus = $query->paginate(10)->withQueryString();

        return response()->json($bukus, 200);
    }

    /**
     * Soal 3.b: Menyimpan data buku baru (HTTP 201)
     */
    public function store(StoreBukuRequest $request): JsonResponse
    {
        // Menggunakan $request->validated() untuk proteksi Mass Assignment
        $buku = Buku::create($request->validated());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data'    => $buku->load('kategori'),
        ], 201);
    }

    /**
     * Soal 3.c: Menampilkan detail satu buku (HTTP 200 / 404)
     */
    public function show($id): JsonResponse
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        return response()->json([
            'data' => $buku
        ], 200);
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
            'data'    => $buku->load('kategori'),
        ], 200);
    }

    /**
     * Soal 3.e: Menghapus data buku (HTTP 200 / 404)
     */
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
}
