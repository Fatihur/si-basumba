<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsalPermintaan;
use App\Models\JenisLitmas;
use App\Models\Litmas;
use App\Models\LitmasFile;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LitmasController extends Controller
{
    public function index(Request $request)
    {
        $query = Litmas::with('asalPermintaan', 'jenisLitmas', 'petugas');

        if ($request->filled('search')) {
            $query->where('nama_narapidana', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_registrasi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $litmas = $query->orderBy('created_at', 'desc')->paginate(10);
        $petugas = Petugas::where('is_active', true)->get();

        return view('admin.litmas.index', compact('litmas', 'petugas'));
    }

    public function show(Litmas $litma)
    {
        $litma->load('asalPermintaan', 'jenisLitmas', 'petugas', 'files');
        return view('admin.litmas.show', compact('litma'));
    }

    public function updateStatus(Request $request, Litmas $litma)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
            'petugas_id' => 'nullable|exists:petugas,id',
            'catatan' => 'nullable|string',
        ]);

        $litma->update($validated);

        return redirect()->route('admin.litmas.show', $litma)
            ->with('success', 'Status LITMAS berhasil diperbarui.');
    }

    public function downloadFile(LitmasFile $file)
    {
        if (Storage::disk('public')->exists($file->path)) {
            return Storage::disk('public')->download($file->path, $file->nama_file);
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}
