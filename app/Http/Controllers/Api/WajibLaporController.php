<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Petugas;
use App\Models\WajibLapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WajibLaporController extends Controller
{
    public function getPetugas()
    {
        $petugas = Petugas::where('is_active', true)
            ->select('id', 'nama_lengkap', 'jabatan')
            ->orderBy('nama_lengkap')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $petugas,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_lapor' => 'required|date',
            'email' => 'required|email',
            'nama_lengkap' => 'required|string|max:255',
            'kategori_klien' => 'required|in:anak,dewasa',
            'no_wa' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status_bimbingan' => 'required|in:pembebasan_bersyarat,cuti_bersyarat,asimilasi,cmd',
            'petugas_id' => 'required|exists:petugas,id',
            'foto_selfie' => 'required|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fotoPath = $request->file('foto_selfie')->store('wajib-lapor', 'public');

        $wajibLapor = WajibLapor::create([
            'tanggal_lapor' => $request->tanggal_lapor,
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap,
            'kategori_klien' => $request->kategori_klien,
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
            'status_bimbingan' => $request->status_bimbingan,
            'petugas_id' => $request->petugas_id,
            'foto_selfie' => $fotoPath,
        ]);

        Notification::create([
            'type' => 'info',
            'title' => 'Wajib Lapor Baru',
            'message' => "Laporan baru dari {$request->nama_lengkap} ({$request->email})",
            'source' => 'mobile',
            'icon' => 'bi-clipboard-check',
            'link' => route('admin.wajib-lapor.show', $wajibLapor->id),
            'model_type' => WajibLapor::class,
            'model_id' => $wajibLapor->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wajib lapor berhasil dikirim',
            'data' => $wajibLapor,
        ], 201);
    }

    public function checkStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $laporan = WajibLapor::where('email', $request->email)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get(['id', 'tanggal_lapor', 'status_verifikasi', 'catatan_verifikasi', 'created_at']);

        return response()->json([
            'success' => true,
            'data' => $laporan,
        ]);
    }
}
