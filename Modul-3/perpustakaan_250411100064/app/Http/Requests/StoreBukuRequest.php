<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Wajib diubah ke true agar request diizinkan
    }

    public function rules(): array
    {
        $tahunSekarang = date('Y');

        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', "between:1900,{$tahunSekarang}"],
        ];
    }

    // Custom Error Message Bahasa Indonesia (Soal 2.c)
    public function messages(): array
    {
        return [
            'required'           => ':attribute wajib diisi.',
            'string'             => ':attribute harus berupa teks.',
            'integer'            => ':attribute harus berupa angka.',
            'min'                => ':attribute minimal :min karakter.',
            'max'                => ':attribute maksimal :max karakter.',
            'between'            => ':attribute harus antara :min sampai :max.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ];
    }

    // Nama atribut ramah pengguna (Soal 2.d)
    public function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul buku',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ];
    }
}