<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Master 1: Kategori Utama (Cash, Bank, E-Wallet)
        Schema::create('payment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Bank, E-Wallet, QRIS
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Master 2: Metode Spesifik (BCA, Mandiri, OVO)
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            // Menghubungkan metode spesifik ke kategori utama
            $table->foreignId('payment_category_id')->constrained()->onDelete('restrict');
            $table->string('name'); // Contoh: BCA, OVO, ShopeePay
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('payment_categories');
    }
};