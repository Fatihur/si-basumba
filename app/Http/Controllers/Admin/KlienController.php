<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Klien;
use App\Models\Petugas;
use Illuminate\Http\Request;

class KlienController extends Controller
{
    public function index(Request $request)
    {
        $query = Klien::with('petugas');

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'aktif');
        }

        $klien = $query->orderBy('created_at', 'desc')->paginate(10);
        $petugas = Petugas::where('is_active', true)->get();

        return view('admin.klien.index', compact('klien', 'petugas'));
    }

    public function create()
    {
        $petugas = Petugas::where('is_active', true)->get();
        return view('admin.klien.create', compact('petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kategori' => 'required|in:anak,dewasa',
            'status_bimbingan' => 'nullable|in:pembebasan_bersyarat,cuti_bersyarat,asimilasi,cmd',
            'petugas_id' => 'nullable|exists:petugas,id',
            'tanggal_mulai_bimbingan' => 'nullable|date',
            'tanggal_selesai_bimbingan' => 'nullable|date|after:tanggal_mulai_bimbingan',
        ]);

        Klien::create($validated);

        return redirect()->route('admin.klien.index')
            ->with('success', 'Data klien berhasil ditambahkan.');
    }

    public function show(Klien $klien)
    {
        $klien->load('petugas');
        return view('admin.klien.show', compact('klien'));
    }

    public function edit(Klien $klien)
    {
        $petugas = Petugas::where('is_active', true)->get();
        return view('admin.klien.edit', compact('klien', 'petugas'));
    }

    public function update(Request $request, Klien $klien)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kategori' => 'required|in:anak,dewasa',
            'status_bimbingan' => 'nullable|in:pembebasan_bersyarat,cuti_bersyarat,asimilasi,cmd',
            'petugas_id' => 'nullable|exists:petugas,id',
            'tanggal_mulai_bimbingan' => 'nullable|date',
            'tanggal_selesai_bimbingan' => 'nullable|date|after:tanggal_mulai_bimbingan',
            'is_active' => 'boolean',
        ]);

        $klien->update($validated);

        return redirect()->route('admin.klien.index')
            ->with('success', 'Data klien berhasil diperbarui.');
    }

    public function destroy(Klien $klien)
    {
        $klien->delete();

        return redirect()->route('admin.klien.index')
            ->with('success', 'Data klien berhasil dihapus.');
    }
}
