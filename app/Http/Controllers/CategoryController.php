<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('tasks')
            ->orderBy('name')
            ->paginate(20);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories|regex:/^[\pL\s\-]+$/u',
            'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string|max:1000',
        ]);

        $category = Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'category created successfully');
    }

    public function show(Category $category)
    {
        $category->load(['tasks.user', 'tasks.project']);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . '|regex:/^[\pL\s\-]+$/u',
            'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'category deleted successfully');
    }
}
