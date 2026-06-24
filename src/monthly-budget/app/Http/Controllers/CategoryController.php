<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Auth::user()->categories()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense'
        ]);

        Auth::user()->categories()->create($request->all());

        return redirect()->back()->with('success', 'Kategorija pridėta!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id())
        {
            abort(403);
        }

        if (Auth::user()->categories()->count() === 1)
        {
            return redirect()->back()->with('error', 'Turi buti bent viena kategorija!');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Kategorija ištrinta!');
    }
}
