<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Petugas;
use App\Models\WajibLapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WajibLaporController extends Controller
{
    public function index(Request $request)
    {
        $query = WajibLapor::with('petugas', 'verifiedByUser');

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_lapor', $request->tanggal);
        }

        $wajibLapor = $query->orderBy('created_at', 'desc')->paginate(10);
        $petugas = Petugas::where('is_active', true)->get();

        return view('admin.wajib-lapor.index', compact('wajibLapor', 'petugas'));
    }

    public function show(WajibLapor $wajibLapor)
    {
        $wajibLapor->load('petugas', 'verifiedByUser');
        return view('admin.wajib-lapor.show', compact('wajibLapor'));
    }

    public function verify(Request $request, WajibLapor $wajibLapor)
    {
        $validated = $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $wajibLapor->update([
            'status_verifikasi' => $validated['status_verifikasi'],
            'catatan_verifikasi' => $validated['catatan_verifikasi'],
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        $statusText = $validated['status_verifikasi'] === 'disetujui' ? 'Disetujui' : 'Ditolak';
        Notification::create([
            'type' => $validated['status_verifikasi'] === 'disetujui' ? 'success' : 'warning',
            'title' => 'Wajib Lapor Diverifikasi',
            'message' => "Laporan {$wajibLapor->nama_lengkap} telah {$statusText} oleh " . auth()->user()->name,
            'source' => 'web',
            'icon' => 'bi-clipboard-check',
            'link' => route('admin.wajib-lapor.show', $wajibLapor->id),
            'model_type' => WajibLapor::class,
            'model_id' => $wajibLapor->id,
        ]);

        return redirect()->route('admin.wajib-lapor.index')
            ->with('success', 'Wajib lapor berhasil diverifikasi.');
    }

    public function export(Request $request)
    {
        $query = WajibLapor::with('petugas');

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_lapor', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_lapor', '<=', $request->sampai);
        }

        $data = $query->orderBy('tanggal_lapor', 'desc')->get();

        // Simple CSV export
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="wajib-lapor-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Nama', 'Email', 'No WA', 'Kategori', 'Status Bimbingan', 'PK/APK', 'Status Verifikasi']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row->tanggal_lapor->format('d/m/Y'),
                    $row->nama_lengkap,
                    $row->email,
                    $row->no_wa,
                    $row->kategori_klien,
                    $row->status_bimbingan,
                    $row->petugas?->nama_lengkap ?? '-',
                    $row->status_verifikasi,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
