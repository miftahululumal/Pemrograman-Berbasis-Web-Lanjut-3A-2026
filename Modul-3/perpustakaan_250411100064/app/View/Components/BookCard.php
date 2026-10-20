<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookCard extends Component
{
    public function __construct(
        public string $judul,
        public string $penulis,
        public int $tahun,
        public string $url,
        public string $cover
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.book-card');
    }
}