<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->string('status')->default('menunggu');
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('diproses_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['diproses_oleh']);
            $table->dropColumn([
                'status',
                'alasan_penolakan',
                'diproses_oleh',
            ]);
        });
    }
};