<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsalPermintaan;
use App\Models\JenisLitmas;
use App\Models\Litmas;
use App\Models\LitmasFile;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LitmasController extends Controller
{
    public function getMasterData()
    {
        $asalPermintaan = AsalPermintaan::where('is_active', true)
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        $jenisLitmas = JenisLitmas::where('is_active', true)
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'asal_permintaan' => $asalPermintaan,
                'jenis_litmas' => $jenisLitmas,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asal_permintaan_id' => 'required|exists:asal_permintaan,id',
            'jenis_litmas_id' => 'required|exists:jenis_litmas,id',
            'nama_narapidana' => 'required|string|max:255',
            'nomor_registrasi' => 'required|string|max:100',
            'tindak_pidana_pasal' => 'required|string',
            'nomor_putusan' => 'nullable|string|max:100',
            'tanggal_putusan' => 'nullable|date',
            'tanggal_mulai_ditahan' => 'nullable|date',
            'lama_pidana' => 'nullable|string|max:100',
            'sepertiga_masa_hukuman' => 'nullable|date',
            'duapertiga_masa_hukuman' => 'nullable|date',
            'tanggal_ekspirasi' => 'nullable|date',
            'nama_penjamin' => 'nullable|string|max:255',
            'hubungan_penjamin' => 'nullable|string|max:100',
            'telepon_penjamin' => 'nullable|string|max:20',
            'files.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $litmas = Litmas::create($request->except('files'));

            $fileTypes = [
                'print_summary', 'ispn', 'berkas_putusan', 'laporan_perkembangan',
                'salinan_register_f', 'kk_klien', 'ktp_klien', 'ktp_penjamin', 'kk_penjamin'
            ];

            foreach ($fileTypes as $type) {
                if ($request->hasFile($type)) {
                    $file = $request->file($type);
                    $path = $file->store('litmas/' . $litmas->id, 'public');

                    LitmasFile::create([
                        'litmas_id' => $litmas->id,
                        'jenis_file' => $type,
                        'nama_file' => $file->getClientOriginalName(),
                        'path' => $path,
                    ]);
                }
            }

            Notification::create([
                'type' => 'info',
                'title' => 'Permohonan LITMAS Baru',
                'message' => "Permohonan LITMAS baru untuk {$litmas->nama_narapidana} (Reg: {$litmas->nomor_registrasi})",
                'source' => 'mobile',
                'icon' => 'bi-file-earmark-text',
                'link' => route('admin.litmas.show', $litmas->id),
                'model_type' => Litmas::class,
                'model_id' => $litmas->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permohonan LITMAS berhasil dikirim',
                'data' => $litmas->load('files'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
