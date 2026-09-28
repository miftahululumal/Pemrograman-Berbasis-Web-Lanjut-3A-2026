<div class="book-card">

    <div class="book-cover">
        <img src="{{ $cover }}" alt="Cover Buku {{ $judul }}">
    </div>

    <div class="book-content">

        <h3>
            {{ $judul }}
        </h3>

        <p class="book-author">
            Penulis: {{ $penulis }}
        </p>

        <p class="book-year">
            Tahun Terbit: {{ $tahun }}
        </p>

        <div class="book-extra">
            {{ $slot }}
        </div>

        <a href="{{ $url }}" class="btn">
            Lihat Detail
        </a>

    </div>

</div>