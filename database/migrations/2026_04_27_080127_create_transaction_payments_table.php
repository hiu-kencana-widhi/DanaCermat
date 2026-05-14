<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('restrict');
            $table->bigInteger('amount');
            $table->timestamps();
        });

        // Migrasi data dari tabel transactions ke transaction_payments
        $transactions = DB::table('transactions')->get();
        foreach ($transactions as $transaction) {
            DB::table('transaction_payments')->insert([
                'transaction_id' => $transaction->id,
                'payment_method_id' => $transaction->payment_method_id,
                'amount' => $transaction->amount,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
            ]);
        }

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('payment_method_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_payments');
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('payment_method_id')->nullable(false)->change();
        });
    }
};
