<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::withCount('todos')->where('user_id', Auth::id())->get();
        return view('category.index', compact('category'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Category::create([
            'title'    => $request->title,
            'user_id'  => Auth::id(), // tambahkan ini!
        ]);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return redirect()->route('category.index')->with('danger', 'Unauthorized action.');
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['title' => 'required']);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('category.index');
    }
}
