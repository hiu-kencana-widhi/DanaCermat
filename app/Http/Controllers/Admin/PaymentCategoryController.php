<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentCategoryController extends Controller
{
    public function index()
    {
        $categories = PaymentCategory::orderBy('sort_order', 'asc')->get();
        return view('admin.payment-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.payment-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        PaymentCategory::create([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment-categories.index')->with('success', 'Kategori utama berhasil ditambah.');
    }

    public function edit(PaymentCategory $paymentCategory)
    {
        return view('admin.payment-categories.edit', compact('paymentCategory'));
    }

    public function update(Request $request, PaymentCategory $paymentCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer',
        ]);

        $paymentCategory->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment-categories.index')->with('success', 'Kategori utama diperbarui.');
    }

    public function destroy(PaymentCategory $paymentCategory)
    {
        DB::transaction(function () use ($paymentCategory) {
            $paymentCategory->paymentMethods()->delete();
            $paymentCategory->delete();
        });

        return redirect()->route('admin.payment-categories.index')->with('success', 'Kategori utama dihapus.');
    }
}
