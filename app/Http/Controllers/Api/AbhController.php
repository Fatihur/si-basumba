<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Abh;
use App\Models\InstansiKepolisian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbhController extends Controller
{
    public function getInstansi()
    {
        $instansi = InstansiKepolisian::where('is_active', true)
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $instansi,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instansi_kepolisian_id' => 'required|exists:instansi_kepolisian,id',
            'nomor_surat_permintaan' => 'required|string|max:100',
            'tanggal_surat_permintaan' => 'required|date',
            'file_surat_permintaan' => 'required|file|max:10240',
            'perkara_kasus' => 'required|string',
            'nama_penyidik' => 'required|string|max:255',
            'telepon_penyidik' => 'required|string|max:20',
            'file_bap' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fileSuratPath = $request->file('file_surat_permintaan')->store('abh/surat', 'public');

        $data = $request->except(['file_surat_permintaan', 'file_bap']);
        $data['file_surat_permintaan'] = $fileSuratPath;

        if ($request->hasFile('file_bap')) {
            $data['file_bap'] = $request->file('file_bap')->store('abh/bap', 'public');
        }

        $abh = Abh::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran ABH berhasil dikirim',
            'data' => $abh,
        ], 201);
    }
}
