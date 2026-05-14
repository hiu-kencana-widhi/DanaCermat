<?php

namespace Tests\Feature;

use App\Models\PaymentCategory;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_transactions_index_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $paymentMethod = $this->createPaymentMethod();

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'income',
            'amount' => 150000,
            'description' => 'Gaji mingguan',
            'transaction_date' => now()->toDateString(),
            'payment_method_id' => $paymentMethod->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('transactions.index'));

        $response
            ->assertOk()
            ->assertSee('Riwayat Transaksi')
            ->assertSee('Gaji mingguan');
    }

    public function test_create_transaction_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('transactions.create'));

        $response
            ->assertOk()
            ->assertSee('Tambah Transaksi');
    }

    public function test_user_can_store_income_transaction(): void
    {
        $user = User::factory()->create();
        $paymentMethod = $this->createPaymentMethod();

        $response = $this
            ->actingAs($user)
            ->post(route('transactions.store'), [
                'type' => 'income',
                'amount' => 250000,
                'description' => 'Bonus proyek',
                'transaction_date' => now()->toDateString(),
                'payment_method_id' => $paymentMethod->id,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('transactions.index'));

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'type' => 'income',
            'amount' => 250000,
            'description' => 'Bonus proyek',
            'payment_method_id' => $paymentMethod->id,
        ]);
    }

    public function test_edit_transaction_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $paymentMethod = $this->createPaymentMethod();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'income',
            'amount' => 175000,
            'description' => 'Penjualan',
            'transaction_date' => now()->toDateString(),
            'payment_method_id' => $paymentMethod->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('transactions.edit', $transaction));

        $response
            ->assertOk()
            ->assertSee('Edit Transaksi')
            ->assertSee($paymentMethod->name);
    }

    private function createPaymentMethod(): PaymentMethod
    {
        $category = PaymentCategory::create([
            'name' => 'Bank',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        return PaymentMethod::create([
            'payment_category_id' => $category->id,
            'name' => 'BCA',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
}
