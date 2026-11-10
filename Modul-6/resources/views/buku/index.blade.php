@extends('layouts.app')

@section('content')

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap");
        :root {
            --primary-gradient: linear-gradient(135deg, #0b2b1f 0%, #164a36 50%, #226d50 100%);
            --btn-gradient: linear-gradient(135deg, #2d6a4f 0%, #1b4332 100%);
            --accent-glow: rgba(45, 106, 79, 0.35);
            --bg-body: #f0f4f2;
            --card-radius: 24px;
            --transition-bounce: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Glass Navbar */
        .navbar-custom {
            background: var(--primary-gradient);
            box-shadow: 0 12px 40px var(--accent-glow);
            backdrop-filter: blur(10px);
        }

        /* Glassmorphism Cards */
        .header-card, .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--card-radius);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.6);
            transition: var(--transition-bounce);
        }

        .card-header-custom {
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem 1.75rem;
            background: transparent;
        }

        /* Modal Pop-up dengan Latar Belakang Blur */
        .modal-backdrop.show {
            backdrop-filter: blur(8px);
            background-color: rgba(15, 23, 42, 0.5);
        }

        .modal-content-blur {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            border-radius: var(--card-radius);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        }

        /* Notifikasi Center dengan Animasi Membesar & Meledak */
        .custom-alert-center {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.2);
            z-index: 9999;
            min-width: 340px;
            max-width: 460px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3), 0 0 40px rgba(45, 106, 79, 0.2);
            padding: 2rem;
            text-align: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: none;
        }

        /* Animasi Masuk: Pop-Up Membesar */
        .custom-alert-center.show {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, -50%) scale(1.15);
            pointer-events: auto;
        }

        /* Animasi Keluar: Efek Meledak / Pecah Berhamburan (Explode / Dissolve) */
        .custom-alert-center.explode-out {
            animation: explodeAnim 0.5s cubic-bezier(0.6, -0.28, 0.735, 0.045) forwards;
        }

        @keyframes explodeAnim {
            0% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1.15);
                filter: blur(0px);
            }
            50% {
                opacity: 0.8;
                transform: translate(-50%, -50%) scale(1.5);
                filter: blur(4px);
            }
            100% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(2.2);
                filter: blur(20px);
                letter-spacing: 10px;
            }
        }

        /* Ikon Berdetak Saat Muncul */
        .custom-alert-center .alert-icon {
            font-size: 3.8rem;
            line-height: 1;
            margin-bottom: 0.85rem;
            display: inline-block;
            animation: bounceIcon 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes bounceIcon {
            0% { transform: scale(0.2) rotate(-20deg); }
            60% { transform: scale(1.3) rotate(10deg); }
            100% { transform: scale(1) rotate(0deg); }
        }

        /* Partikel Ledakan Kembang Api Kecil */
        .particle-spark {
            position: fixed;
            pointer-events: none;
            border-radius: 50%;
            z-index: 10000;
            animation: popParticle 0.6s ease-out forwards;
        }

        @keyframes popParticle {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(var(--dx), var(--dy)) scale(0);
                opacity: 0;
            }
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: 14px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1.1rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            background-color: #ffffff;
            border-color: #2d6a4f;
            box-shadow: 0 0 0 5px rgba(45, 106, 79, 0.18);
            transform: scale(1.01);
        }

        /* Buttons */
        .btn-action-primary {
            background: var(--btn-gradient);
            color: #fff;
            border-radius: 14px;
            border: none;
            padding: 0.75rem 1.4rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            transition: var(--transition-bounce);
            box-shadow: 0 10px 20px var(--accent-glow);
        }

        .btn-action-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(45, 106, 79, 0.45);
            color: #fff;
        }

        /* Table Styling */
        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .custom-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 1.2rem 1.25rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .custom-table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideUpRow 0.5s ease-out forwards;
        }

        @keyframes slideUpRow {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-table tbody tr:hover {
            background-color: #edf7f2 !important;
            transform: scale(1.002);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
        }

        .custom-table tbody td {
            padding: 1.15rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* Badges */
        .badge-kategori {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #14532d;
            border: 1px solid #86efac;
            border-radius: 50px;
            padding: 0.45rem 0.95rem;
            font-weight: 700;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.12);
        }

        .badge-tahun {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #38edf8;
            border-radius: 12px;
            padding: 0.4rem 0.85rem;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
            display: inline-block;
        }

        /* Quick Actions */
        .btn-edit {
            background-color: #fef3c7;
            color: #d97706;
            border: none;
            border-radius: 12px;
            padding: 0.5rem 0.85rem;
            font-weight: 700;
            transition: var(--transition-bounce);
        }

        .btn-edit:hover {
            background-color: #fde68a;
            color: #78350f;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(217, 119, 6, 0.25);
        }

        .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 12px;
            padding: 0.5rem 0.85rem;
            font-weight: 700;
            transition: var(--transition-bounce);
        }

        .btn-delete:hover {
            background-color: #fecaca;
            color: #7f1d1d;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.25);
        }

        /* Pagination */
        .pagination .page-link {
            color: #1b4332;
            border-radius: 12px;
            margin: 0 3px;
            font-weight: 800;
            font-size: 0.85rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background: var(--btn-gradient);
            border-color: #1b4332;
            color: #fff;
            box-shadow: 0 6px 16px var(--accent-glow);
        }
    </style>

    <div class="container pb-5">
        <!-- Banner Title & Actions -->
        <div class="header-card p-4 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-extrabold mb-1 text-dark d-flex align-items-center gap-2">
                    Manajemen Data Buku 
                    <span class="badge bg-success bg-opacity-10 text-success fs-7 rounded-pill px-3 py-1 border border-success border-opacity-20">Live Sync</span>
                </h4>
                <p class="text-muted small mb-0 fw-medium">Kelola koleksi buku dengan antarmuka cepat, responsif, dan interaktif.</p>
            </div>
            <div>
                <!-- MENGARAHKAN KE DASHBOARD UTAMA BREEZE -->
                <a href="{{ route('dashboard') }}" class="btn btn-outline-success btn-sm fw-bold rounded-pill px-4 py-2 shadow-sm transition">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Table Section (Full Width) -->
        <div class="dashboard-card">
            <div class="card-header-custom d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <h6 class="fw-bold text-dark mb-0 fs-5 d-flex align-items-center gap-2">
                    <i class="bi bi-collection-fill text-success"></i> Daftar Koleksi Buku
                </h6>
                
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <!-- Search Input -->
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="search-input" onkeyup="filterBuku()" class="form-control form-control-sm border-start-0 rounded-end-3" placeholder="Cari judul, penulis, tahun...">
                    </div>

                    <!-- Tombol Refresh -->
                    <button class="btn btn-sm btn-outline-secondary rounded-3" onclick="loadBuku()" title="Refresh Data">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                    
                    <!-- Tombol Tambah Buku hanya muncul jika punya permission -->
                    @can('kelola-buku')
                        <button class="btn btn-action-primary btn-sm px-3 ms-sm-2 d-flex align-items-center gap-1" onclick="openAddModal()">
                            <i class="bi bi-plus-lg fs-6"></i> Tambah Buku
                        </button>
                    @endcan
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table custom-table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 65px;">No</th>
                                <th>Kategori</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th class="text-center" style="width: 130px;">Tahun</th>
                                <!-- Baris 69: Header Aksi disembunyikan untuk Siswa -->
                                @can('kelola-buku')
                                    <th class="text-center" style="width: 140px;">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody id="buku-table-body">
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="spinner-border spinner-border-sm text-success me-2" role="status"></div>
                                    Memuat data koleksi buku...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-top-0 p-3 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <div class="small text-muted fw-bold" id="pagination-info">
                    Menampilkan 0 data
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0" id="pagination-controls">
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Form Pop-up (Tambah/Edit Buku) -->
    <div class="modal fade" id="bukuModal" tabindex="-1" aria-labelledby="bukuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-blur">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-extrabold text-dark d-flex align-items-center gap-2" id="bukuModalLabel">
                        <i class="bi bi-plus-circle-fill text-success" id="modal-icon"></i>
                        <span id="modal-title-text">Tambah Buku Baru</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="buku-form" novalidate>
                        <input type="hidden" id="buku-id">

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label small fw-bold text-secondary">Kategori Buku</label>
                            <select id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="judul" class="form-label small fw-bold text-secondary">Judul Buku</label>
                            <input type="text" id="judul" class="form-control" placeholder="Masukkan judul buku..." required>
                        </div>

                        <div class="mb-3">
                            <label for="penulis" class="form-label small fw-bold text-secondary">Penulis</label>
                            <input type="text" id="penulis" class="form-control" placeholder="Hanya huruf (cth: Dian Sastro)" required>
                            <div class="form-text text-muted" style="font-size: 0.75rem;">*Tidak boleh diisi angka sembarangan.</div>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label small fw-bold text-secondary">Tahun Terbit</label>
                            <input type="number" id="tahun_terbit" class="form-control" placeholder="Contoh: 2024" min="1900" max="{{ date('Y') }}" required>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light border fw-bold rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-action-primary" id="btn-submit">
                                <i class="bi bi-check-lg me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    const API_URL = '/api/buku';
    let globalDataBuku = [];
    let filteredDataBuku = [];
    let currentPage = 1;
    const rowsPerPage = 10;
    let bukuModalInstance = null;

    // Pass izin user ke JavaScript
    const canManageBuku = @json(auth()->user() ? auth()->user()->can('Kelola data buku') : false);

    document.addEventListener('DOMContentLoaded', () => {
        bukuModalInstance = new bootstrap.Modal(document.getElementById('bukuModal'));
        loadBuku();
        document.getElementById('buku-form').addEventListener('submit', handleFormSubmit);
    });

    // Custom Toast Alert Center
    function showAlert(message, type = 'success') {
        let alertBox = document.getElementById('custom-toast-alert');

        if (!alertBox) {
            alertBox = document.createElement('div');
            alertBox.id = 'custom-toast-alert';
            alertBox.className = 'custom-alert-center';
            document.body.appendChild(alertBox);
        }

        alertBox.classList.remove('show', 'explode-out');

        const isSuccess = type === 'success';
        const iconClass = isSuccess ? 'bi-check-circle-fill text-success' : 'bi-exclamation-triangle-fill text-danger';
        const titleText = isSuccess ? 'Berhasil!' : 'Terjadi Kesalahan!';

        alertBox.innerHTML = `
            <div class="alert-icon">
                <i class="bi ${iconClass}"></i>
            </div>
            <h4 class="fw-extrabold mb-2 text-dark" style="letter-spacing: -0.5px;">${titleText}</h4>
            <p class="text-secondary small mb-0 fw-bold fs-6">${message}</p>
        `;

        setTimeout(() => {
            alertBox.classList.add('show');
        }, 10);

        setTimeout(() => {
            triggerExplosionParticles();
            alertBox.classList.remove('show');
            alertBox.classList.add('explode-out');
        }, 1800);
    }

    function triggerExplosionParticles() {
        const particleCount = 22;
        const colors = ['#2d6a4f', '#52b788', '#74c69d', '#d8f3dc', '#ffb703', '#e63946'];

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle-spark';
            
            const size = Math.random() * 10 + 6;
            const color = colors[Math.floor(Math.random() * colors.length)];
            
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.backgroundColor = color;
            
            particle.style.left = `50%`;
            particle.style.top = `50%`;

            const angle = Math.random() * Math.PI * 2;
            const velocity = Math.random() * 220 + 100;
            const dx = `${Math.cos(angle) * velocity}px`;
            const dy = `${Math.sin(angle) * velocity}px`;

            particle.style.setProperty('--dx', dx);
            particle.style.setProperty('--dy', dy);

            document.body.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 600);
        }
    }

    // no 5
    function validateInput(payload) {
        const errors = [];
        const currentYear = new Date().getFullYear();
        const penulisRegex = /^[a-zA-Z\s\.\,\'\-]+$/;

        if (!payload.kategori_id) {
            errors.push("Kategori buku wajib dipilih.");
        }
        if (!payload.judul || payload.judul.trim().length < 2) {
            errors.push("Judul buku minimal terdiri dari 2 karakter.");
        }
        if (!payload.penulis || payload.penulis.trim().length < 3) {
            errors.push("Nama penulis minimal 3 karakter.");
        } else if (!penulisRegex.test(payload.penulis)) {
            errors.push("Nama penulis tidak boleh mengandung angka atau simbol khusus!");
        }
        if (!payload.tahun_terbit || payload.tahun_terbit < 1900 || payload.tahun_terbit > currentYear) {
            errors.push(`Tahun terbit harus berupa angka 4 digit antara 1900 hingga ${currentYear}.`);
        }

        return errors;
    }

    function openAddModal() {
        resetForm();
        document.getElementById('modal-icon').className = 'bi bi-plus-circle-fill text-success';
        document.getElementById('modal-title-text').innerText = 'Tambah Buku Baru';
        document.getElementById('btn-submit').innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan Data';
        document.getElementById('btn-submit').className = 'btn btn-action-primary';
        bukuModalInstance.show();
    }
    // soal nomor 1
    async function loadBuku() {
        const tbody = document.getElementById('buku-table-body');
        try {
            const response = await fetch(API_URL, { headers: { 'Accept': 'application/json' } });
            if (!response.ok) throw new Error('Gagal mengambil data dari server.');

            const result = await response.json();
            globalDataBuku = (result.data || []).sort((a, b) => a.id - b.id);
            filteredDataBuku = [...globalDataBuku];

            currentPage = 1;
            renderTable();
        } catch (error) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger py-4">Gagal memuat data dari server.</td></tr>';
            showAlert(error.message, 'danger');
        }
    }

    function filterBuku() {
        const keyword = document.getElementById('search-input').value.toLowerCase().trim();

        filteredDataBuku = globalDataBuku.filter(buku => {
            if (!keyword) return true;
            return (buku.judul || '').toLowerCase().includes(keyword) ||
                   (buku.penulis || '').toLowerCase().includes(keyword) ||
                   (buku.kategori || '').toLowerCase().includes(keyword) ||
                   String(buku.tahun || '').includes(keyword);
        });

        currentPage = 1;
        renderTable();
    }

    function renderTable() {
        const tbody = document.getElementById('buku-table-body');
        tbody.innerHTML = '';

        if (filteredDataBuku.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted fw-medium">Tidak ada data buku yang ditemukan.</td></tr>';
            renderPaginationControls(0);
            document.getElementById('pagination-info').innerText = 'Menampilkan 0 data';
            return;
        }

        const totalItems = filteredDataBuku.length;
        const totalPages = Math.ceil(totalItems / rowsPerPage);

        if (currentPage > totalPages) currentPage = totalPages;

        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, totalItems);
        const pageData = filteredDataBuku.slice(startIndex, endIndex);

        pageData.forEach((buku, index) => {
            const rowNumber = startIndex + index + 1;

            let actionButtons = '';
            if (canManageBuku) {
                actionButtons = `
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn btn-edit btn-sm" onclick="editBuku(${buku.id})" title="Ubah Data">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-delete btn-sm" onclick="deleteBuku(${buku.id})" title="Hapus Buku">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                `;
            } else {
                actionButtons = `
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-eye-fill me-1"></i> Hanya Lihat
                    </span>
                `;
            }

            // A1: Escape HTML to prevent XSS
            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            tbody.innerHTML += `
                <tr style="animation-delay: ${index * 0.03}s;">
                    <td class="ps-4 fw-bold text-secondary">${rowNumber}</td>
                    <td><span class="badge-kategori"><i class="bi bi-tag-fill small opacity-75"></i>${escapeHtml(buku.kategori)}</span></td>
                    <td><span class="fw-bold text-dark">${escapeHtml(buku.judul)}</span></td>
                    <td class="text-secondary fw-medium">${escapeHtml(buku.penulis)}</td>
                    <td class="text-center"><span class="badge-tahun">${escapeHtml(buku.tahun)}</span></td>
                    <td class="text-center">${actionButtons}</td>
                </tr>
            `;
        });

        document.getElementById('pagination-info').innerText = `Menampilkan ${startIndex + 1} - ${endIndex} dari ${totalItems} data`;
        renderPaginationControls(totalPages);
    }

    function renderPaginationControls(totalPages) {
        const paginationList = document.getElementById('pagination-controls');
        paginationList.innerHTML = '';

        if (totalPages <= 1) return;

        paginationList.innerHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;"><i class="bi bi-chevron-left"></i></a>
            </li>
        `;

        for (let i = 1; i <= totalPages; i++) {
            paginationList.innerHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a>
                </li>
            `;
        }

        paginationList.innerHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;"><i class="bi bi-chevron-right"></i></a>
            </li>
        `;
    }

    function changePage(page) {
        const totalPages = Math.ceil(filteredDataBuku.length / rowsPerPage);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderTable();
    }

    async function handleFormSubmit(e) {
        e.preventDefault();

        const id = document.getElementById('buku-id').value;
        const payload = {
            kategori_id: document.getElementById('kategori_id').value,
            judul: document.getElementById('judul').value.trim(),
            penulis: document.getElementById('penulis').value.trim(),
            tahun_terbit: document.getElementById('tahun_terbit').value
        };

        const clientErrors = validateInput(payload);
        if (clientErrors.length > 0) {
            showAlert(clientErrors.join('<br>'), 'danger');
            return;
        }

        const isEdit = id !== '';
        const url = isEdit ? `${API_URL}/${id}` : API_URL;
        const method = isEdit ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    const errors = Object.values(result.errors).flat().join('<br>');
                    throw new Error(errors);
                }
                throw new Error(result.message || 'Terjadi kesalahan sistem.');
            }

            bukuModalInstance.hide();
            showAlert(isEdit ? 'Data buku berhasil diperbarui!' : 'Buku baru berhasil ditambahkan!', 'success');
            resetForm();
            loadBuku();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }
    // soal nomor 3
    async function editBuku(id) {
        try {
            const response = await fetch(`${API_URL}/${id}`, { headers: { 'Accept': 'application/json' } });
            if (!response.ok) throw new Error('Gagal mengambil data buku.');

            const result = await response.json();
            const buku = result.data;

            document.getElementById('buku-id').value = buku.id;
            document.getElementById('kategori_id').value = buku.kategori_id;
            document.getElementById('judul').value = buku.judul;
            document.getElementById('penulis').value = buku.penulis;
            document.getElementById('tahun_terbit').value = buku.tahun;

            document.getElementById('modal-icon').className = 'bi bi-pencil-square text-warning';
            document.getElementById('modal-title-text').innerText = 'Ubah Data Buku';
            document.getElementById('btn-submit').innerHTML = '<i class="bi bi-check-lg me-1"></i> Perbarui Data';
            document.getElementById('btn-submit').className = 'btn btn-warning text-white fw-bold';

            bukuModalInstance.show();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }
    // soal 2 3A
    async function deleteBuku(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus buku ini?')) return;

        try {
            const response = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) throw new Error('Gagal menghapus data buku.');

            showAlert('Data buku berhasil dihapus!', 'success');
            loadBuku();
        } catch (error) {
            showAlert(error.message, 'danger');
        }
    }

    function resetForm() {
        document.getElementById('buku-id').value = '';
        document.getElementById('buku-form').reset();
    }
    </script>

@endsection

@can('kelola data buku')
    <a href="{{ route('buku.index') }}">
        Kelola Buku
    </a>
@endcan
