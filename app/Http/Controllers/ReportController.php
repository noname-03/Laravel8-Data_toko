<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        return view('report.category', compact('categories'));
    }
    public function cabang()
    {
        $users = User::where('role', 'user')->get();
        return view('report.cabang', compact('users'));
    }
    public function user()
    {
        $users = User::all();
        return view('report.user', compact('users'));
    }
    public function product_out()
    {
        $transaction = Transaction::where('from_user_id', Auth::user()->id)->get();
        // dd($transaction);
        return view('transaction.index', compact('transaction'));
    }
    public function product_in()
    {
        $transaction = Transaction::where('to_user_id', Auth::user()->id)->get();
        // dd($transactions);
        return view('transaction.index', compact('transaction'));
    }
    public function product($userId)
    {
        $user = User::findOrFail($userId);
        $products = $user->products;
        return view('report.product', [
            'user' => $user,
            'products' => $products
        ]);
    }
}
