<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlurPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlurPelayananController extends Controller
{
    public function index()
    {
        $data = AlurPelayanan::orderBy('urutan')->paginate(10);
        return view('admin.master.alur-pelayanan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'urutan' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('alur-pelayanan', 'public');
        }

        AlurPelayanan::create($validated);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, AlurPelayanan $alurPelayanan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'urutan' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($alurPelayanan->gambar) {
                Storage::disk('public')->delete($alurPelayanan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('alur-pelayanan', 'public');
        }

        $alurPelayanan->update($validated);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(AlurPelayanan $alurPelayanan)
    {
        if ($alurPelayanan->gambar) {
            Storage::disk('public')->delete($alurPelayanan->gambar);
        }
        $alurPelayanan->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
