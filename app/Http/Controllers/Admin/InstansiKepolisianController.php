<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstansiKepolisian;
use Illuminate\Http\Request;

class InstansiKepolisianController extends Controller
{
    public function index()
    {
        $data = InstansiKepolisian::orderBy('nama')->paginate(10);
        return view('admin.master.instansi-kepolisian.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        InstansiKepolisian::create($validated);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, InstansiKepolisian $instansiKepolisian)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $instansiKepolisian->update($validated);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(InstansiKepolisian $instansiKepolisian)
    {
        $instansiKepolisian->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
