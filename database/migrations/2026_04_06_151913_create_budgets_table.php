<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel anggaran.
     */
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (Anggaran milik siapa?)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi ke Kategori Utama (Bukan ke metode spesifik seperti BCA/OVO)
            // Analogi: Kita menganggarkan untuk "Makan" atau "Transport", bukan spesifik "Bayar pakai BCA"
            $table->foreignId('payment_category_id')->constrained()->onDelete('cascade');
            
            $table->bigInteger('amount'); // Nominal target anggaran (Contoh: 2.000.000)
            
            // Format: YYYY-MM (Contoh: 2026-04) agar mudah di-filter per bulan
            $table->string('month'); 
            
            $table->timestamps();

            // Index tambahan untuk optimasi pencarian anggaran per user per bulan
            $table->index(['user_id', 'month']);
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};