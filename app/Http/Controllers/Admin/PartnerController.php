<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        // Logika Pencarian menggunakan LIKE (Soal 3 UTS)
        $partners = Partner::when($search, function($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->latest()->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function create() { return view('admin.partners.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo_url' => 'required|url'
        ]);

        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required',
            'logo_url' => 'required|url'
        ]);

        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui!');
    }

    public function destroy(Partner $partner)
    {
        if($partner->logo_url && !preg_match('/^https?:\/\//', $partner->logo_url)) {
            Storage::disk('public')->delete($partner->logo_url);
        }

        $partner->delete();
        return redirect()->back();
    }
}