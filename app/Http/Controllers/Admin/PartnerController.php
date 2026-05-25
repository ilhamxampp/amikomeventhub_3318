<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of all partners with search functionality.
     */
    public function index(Request $request)
    {
        $query = Partner::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $partners = $query->paginate(10);
        $search = $request->search ?? '';

        return view('admin.partners.index', compact('partners', 'search'));
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created partner in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:partners,name',
            'logo_url' => 'required|url',
        ]);

        Partner::create($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan');
    }

    /**
     * Display the specified partner.
     */
    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified partner in storage.
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:partners,name,' . $id,
            'logo_url' => 'required|url',
        ]);

        $partner->update($validated);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui');
    }

    /**
     * Remove the specified partner from storage.
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus');
    }
}
