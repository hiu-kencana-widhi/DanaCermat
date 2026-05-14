<?php

namespace Tests\Feature;

use App\Models\PaymentCategory;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMasterDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_payment_method_that_has_transaction_history(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $category = $this->createCategory();
        $method = $this->createMethod($category);

        $transaction = $this->createTransaction($user, $method);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.payment-methods.destroy', $method));

        $response->assertRedirect(route('admin.payment-methods.index'));

        $this->assertSoftDeleted($method);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'payment_method_id' => $method->id,
        ]);

        $history = $transaction->fresh()->load('paymentMethod.category');

        $this->assertSame('BCA', $history->paymentMethod?->name);
        $this->assertSame('Bank', $history->paymentMethod?->category?->name);
    }

    public function test_admin_can_delete_category_and_related_methods_without_losing_transaction_history(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $category = $this->createCategory();
        $method = $this->createMethod($category);

        $transaction = $this->createTransaction($user, $method, [
            'description' => 'Belanja bulanan',
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.payment-categories.destroy', $category));

        $response->assertRedirect(route('admin.payment-categories.index'));

        $this->assertSoftDeleted($category);
        $this->assertSoftDeleted($method);
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'payment_method_id' => $method->id,
        ]);

        $history = $transaction->fresh()->load('paymentMethod.category');

        $this->assertSame('BCA', $history->paymentMethod?->name);
        $this->assertSame('Bank', $history->paymentMethod?->category?->name);
    }

    public function test_user_can_still_edit_transaction_after_category_and_method_are_deleted(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $category = $this->createCategory();
        $method = $this->createMethod($category);

        $transaction = $this->createTransaction($user, $method);

        $this->actingAs($admin)->delete(route('admin.payment-categories.destroy', $category));

        $this->actingAs($user)
            ->get(route('transactions.edit', $transaction))
            ->assertOk()
            ->assertSee('BCA')
            ->assertSee('Bank')
            ->assertSee('dihapus dari master');

        $response = $this
            ->actingAs($user)
            ->put(route('transactions.update', $transaction), [
                'type' => 'income',
                'amount' => 200000,
                'description' => 'Gaji revisi',
                'transaction_date' => now()->toDateString(),
                'payment_method_id' => $method->id,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('transactions.index'));

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'description' => 'Gaji revisi',
            'payment_method_id' => $method->id,
        ]);
    }

    private function createAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        return $admin;
    }

    private function createCategory(): PaymentCategory
    {
        return PaymentCategory::create([
            'name' => 'Bank',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createMethod(PaymentCategory $category): PaymentMethod
    {
        return PaymentMethod::create([
            'payment_category_id' => $category->id,
            'name' => 'BCA',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createTransaction(User $user, PaymentMethod $method, array $overrides = []): Transaction
    {
        return Transaction::create(array_merge([
            'user_id' => $user->id,
            'type' => 'income',
            'amount' => 150000,
            'description' => 'Gaji mingguan',
            'transaction_date' => now()->toDateString(),
            'payment_method_id' => $method->id,
        ], $overrides));
    }
}
