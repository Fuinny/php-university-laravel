<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $month = now()->month;
        $year = now()->year;
        $budgetDate = now()->startOfMonth()->toDateString();

        $totalIncome = $user->transactions()
            ->whereHas('category', fn ($q) => $q->where('type', 'income'))
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $totalExpense = $user->transactions()
            ->whereHas('category', fn ($q) => $q->where('type', 'expense'))
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $transactions = $user->transactions()
            ->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $budgets = $user->budgets()
            ->where('budget_date', $budgetDate)
            ->with('category')
            ->get()
            ->map(function($budget) use ($user, $month, $year) {
                $actualSpending = $user->transactions()
                    ->where('category_id', $budget->category_id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->sum('amount');

                $budget->actual_spending = $actualSpending;
                $budget->percentage = $budget->amount_limit > 0
                    ? min(($actualSpending / $budget->amount_limit) * 100, 100)
                    : 0;

                return $budget;
            });

        return view('home', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'transactions',
            'budgets'
        ));
    }
}
