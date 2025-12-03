<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlurPelayanan;

class AlurPelayananController extends Controller
{
    public function index()
    {
        $alur = AlurPelayanan::where('is_active', true)
            ->orderBy('urutan')
            ->get()
            ->map(function ($item) {
                if ($item->gambar) {
                    $item->gambar_url = asset('storage/' . $item->gambar);
                }
                return $item;
            });

        return response()->json([
            'success' => true,
            'data' => $alur,
        ]);
    }
}
