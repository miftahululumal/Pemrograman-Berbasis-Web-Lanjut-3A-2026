<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Petugas
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-600 mt-2">
                    Anda login sebagai Petugas Perpustakaan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @can('Lihat daftar buku')
                <a href="{{ route('buku.index') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Data Buku
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat daftar buku perpustakaan.
                    </p>
                </a>
                @endcan

                @can('Kelola peminjaman')
                <a href="{{ route('peminjaman.index') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Kelola Peminjaman
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Proses peminjaman dan pengembalian buku.
                    </p>
                </a>
                @endcan

                @can('Kelola pengembalian')
                <a href="{{ route('pengembalian.index') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Kelola Pengembalian
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Proses pengembalian buku.
                    </p>
                </a>
                @endcan
                @can('Lihat laporan perpustakaan')
                <a href="{{ route('laporan.index') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Laporan Perpustakaan
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat laporan perpustakaan.
                    </p>
                </a>
                @endcan 
                <a href="{{ route('profile.edit') }}"
                   class="bg-white p-6 shadow-sm rounded-lg hover:bg-gray-50">
                    <h4 class="text-lg font-bold text-gray-800">
                        Profil Saya
                    </h4>
                    <p class="text-gray-600 mt-2">
                        Lihat dan ubah profil akun Anda.
                    </p>
                </a>
            </div>
        </div>
    </div>  
</x-app-layout>