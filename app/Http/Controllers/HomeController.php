<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner; // Tambahkan ini untuk Soal 4 
use App\Models\Category; // Tambahkan ini untuk mendukung Soal 4 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, $categoryId = null)
    {
        $categoryId = $request->query('category', $categoryId);

        $events = Event::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();

        $partners = Partner::all(); // Mengambil data untuk halaman publik
        $categories = Category::all();

        return view('welcome', compact('events', 'partners', 'categories', 'categoryId'));
    }

    public function kategori()
    {
        $categories = Category::withCount('events')->get();

        return view('kategori', compact('categories'));
    }

    public function about()
    {
        return view('tentang-kami');
    }
}