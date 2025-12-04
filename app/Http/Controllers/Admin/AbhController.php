<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Abh;
use App\Models\InstansiKepolisian;
use App\Models\Notification;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbhController extends Controller
{
    public function index(Request $request)
    {
        $query = Abh::with('instansiKepolisian', 'petugas');

        if ($request->filled('search')) {
            $query->where('perkara_kasus', 'like', '%' . $request->search . '%')
                ->orWhere('nama_penyidik', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $abh = $query->orderBy('created_at', 'desc')->paginate(10);
        $petugas = Petugas::where('is_active', true)->get();

        return view('admin.abh.index', compact('abh', 'petugas'));
    }

    public function show(Abh $abh)
    {
        $abh->load('instansiKepolisian', 'petugas');
        return view('admin.abh.show', compact('abh'));
    }

    public function updateStatus(Request $request, Abh $abh)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
            'petugas_id' => 'nullable|exists:petugas,id',
            'catatan' => 'nullable|string',
        ]);

        $abh->update($validated);

        $statusLabels = ['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai'];
        Notification::create([
            'type' => $validated['status'] === 'selesai' ? 'success' : 'info',
            'title' => 'Status ABH Diperbarui',
            'message' => "Pendampingan ABH (No. {$abh->nomor_surat_permintaan}) diubah ke {$statusLabels[$validated['status']]} oleh " . auth()->user()->name,
            'source' => 'web',
            'icon' => 'bi-person-badge',
            'link' => route('admin.abh.show', $abh->id),
            'model_type' => Abh::class,
            'model_id' => $abh->id,
        ]);

        return redirect()->route('admin.abh.show', $abh)
            ->with('success', 'Status ABH berhasil diperbarui.');
    }

    public function uploadFile(Request $request, Abh $abh)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $path = $request->file('file')->store('abh/' . $abh->id, 'public');

        if ($request->type === 'bap') {
            $abh->update(['file_bap' => $path]);
        }

        return back()->with('success', 'File berhasil diupload.');
    }
}
