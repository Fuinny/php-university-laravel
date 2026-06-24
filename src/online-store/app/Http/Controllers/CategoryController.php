<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|unique:categories|max:255']);
        Category::create($validated);
        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
