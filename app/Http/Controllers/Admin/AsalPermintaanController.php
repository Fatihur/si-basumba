<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsalPermintaan;
use Illuminate\Http\Request;

class AsalPermintaanController extends Controller
{
    public function index()
    {
        $data = AsalPermintaan::orderBy('nama')->paginate(10);
        return view('admin.master.asal-permintaan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        AsalPermintaan::create($validated);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, AsalPermintaan $asalPermintaan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $asalPermintaan->update($validated);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(AsalPermintaan $asalPermintaan)
    {
        $asalPermintaan->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
