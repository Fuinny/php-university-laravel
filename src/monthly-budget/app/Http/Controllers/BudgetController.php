<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Use request data if provided, otherwise default to current month/year
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $budgets = $user->budgets()
            ->where('budget_date', "$year-" . $month . "-01")
            ->with('category')
            ->get();

        $categories = $user->categories()->where('type', 'expense')->get();

        return view('budgets.index', compact('budgets', 'categories', 'month', 'year'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'category_id' => 'required|exists:categories,id',
            'amount_limit' => 'required|numeric|min:0',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer'
        ]);

        Auth::user()->budgets()->updateOrCreate(
          [
              'category_id' => $request->category_id,
              'budget_date' => $request->year . '-' . $request->month . '-01'
          ],
          [
              'amount_limit' => $request->amount_limit,
          ]
        );

        return redirect()->back()->with('success', 'Biudžeto limitas atnaujintas');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== Auth::id()) {
            abort(403);
        }

        $budget->delete();

        return redirect()->back()->with('success', 'Biudžeto limitas ištrintas');
    }
}
