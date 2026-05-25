<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partner; // Tambahkan ini untuk Soal 4 
use App\Models\Category; // Tambahkan ini untuk mendukung Soal 4 

class HomeController extends Controller
{
    public function index()
    {
       $events = Event::with('category')->latest()->get();
    $partners = Partner::all(); // Mengambil data untuk halaman publik
    $categories = Category::all();

    return view('welcome', compact('events', 'partners', 'categories'));
    }
}