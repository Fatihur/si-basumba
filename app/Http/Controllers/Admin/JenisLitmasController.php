<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLitmas;
use Illuminate\Http\Request;

class JenisLitmasController extends Controller
{
    public function index()
    {
        $data = JenisLitmas::orderBy('nama')->paginate(10);
        return view('admin.master.jenis-litmas.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        JenisLitmas::create($validated);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, JenisLitmas $jenisLitma)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $jenisLitma->update($validated);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(JenisLitmas $jenisLitma)
    {
        $jenisLitma->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}
