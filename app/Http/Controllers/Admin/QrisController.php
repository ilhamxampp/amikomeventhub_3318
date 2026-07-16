<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrisController extends Controller
{
    public function index()
    {
        return view('admin.qris.index');
    }

    public function update(Request $request)
    {
        return redirect()->route('admin.qris.index')->with('success', 'Pengaturan QRIS berhasil disimpan.');
    }
}
