<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\PaymentCategory; // Tambahkan ini
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        // Load relasi category agar tidak error saat dipanggil di view
        $paymentMethods = PaymentMethod::with('category')
                                       ->orderBy('sort_order', 'asc')
                                       ->latest()
                                       ->paginate(10);
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        // Ambil kategori yang aktif untuk dropdown
        $categories = PaymentCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.payment-methods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_category_id' => 'required|exists:payment_categories,id', // Validasi FK
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        PaymentMethod::create([
            'payment_category_id' => $validated['payment_category_id'],
            'name' => $validated['name'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        $categories = PaymentCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.payment-methods.edit', compact('paymentMethod', 'categories'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'payment_category_id' => 'required|exists:payment_categories,id',
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $paymentMethod->update([
            'payment_category_id' => $validated['payment_category_id'],
            'name' => $validated['name'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
