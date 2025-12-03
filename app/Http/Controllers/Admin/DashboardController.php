<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Abh;
use App\Models\Klien;
use App\Models\Litmas;
use App\Models\Petugas;
use App\Models\WajibLapor;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalKlien = Klien::where('is_active', true)->count();
        $wajibLaporHariIni = WajibLapor::whereDate('tanggal_lapor', $today)->count();
        $wajibLaporMenunggu = WajibLapor::where('status_verifikasi', 'menunggu')->count();
        $totalLitmas = Litmas::count();
        $totalAbh = Abh::count();
        $totalPetugas = Petugas::where('is_active', true)->count();

        $statusMenunggu = WajibLapor::where('status_verifikasi', 'menunggu')->count();
        $statusDisetujui = WajibLapor::where('status_verifikasi', 'disetujui')->count();
        $statusDitolak = WajibLapor::where('status_verifikasi', 'ditolak')->count();

        // Chart data - last 7 days
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            $chartData[] = WajibLapor::whereDate('tanggal_lapor', $date)->count();
        }

        $recentWajibLapor = WajibLapor::with('petugas')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKlien',
            'wajibLaporHariIni',
            'wajibLaporMenunggu',
            'totalLitmas',
            'totalAbh',
            'totalPetugas',
            'statusMenunggu',
            'statusDisetujui',
            'statusDitolak',
            'chartLabels',
            'chartData',
            'recentWajibLapor'
        ));
    }
}
