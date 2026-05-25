<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Partner;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->get();
        $partners = Partner::all();
        return view('welcome', compact('events', 'partners'));
    }
}