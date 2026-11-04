<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->date('tanggal_dikembalikan')->nullable();
            $table->decimal('denda', 12, 2)->default(0);
            $table->string('status_pengembalian')->default('belum dikembalikan');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_dikembalikan',
                'denda',
                'status_pengembalian',
            ]);
        });
    }
};