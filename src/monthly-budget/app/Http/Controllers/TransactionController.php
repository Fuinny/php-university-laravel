<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Default to current month/year if not provided
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $transactions = $user->transactions()
            ->with('category')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->latest('date')
            ->get();

        $categories = $user->categories()->get();

        return view('transactions.index', compact('transactions', 'categories', 'month', 'year'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        Auth::user()->transactions()->create($request->all());

        return redirect()->back()->with('success', 'Transakcija išsaugota!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'Operacija ištrinta!');
    }
}
