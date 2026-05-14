<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $totalTransactions = Transaction::count();
        $recentUsers = User::where('is_admin', false)->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalIncome', 'totalExpense', 'totalTransactions', 'recentUsers'));
    }
}