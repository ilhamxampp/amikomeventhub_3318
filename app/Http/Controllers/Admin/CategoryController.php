<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        // Fitur Pencarian untuk UTS (Soal No. 3)
        $search = $request->input('search');

        $categories = Category::withCount('events')
            // Tambahkan logika pencarian LIKE sesuai instruksi UTS 
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->latest()
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}