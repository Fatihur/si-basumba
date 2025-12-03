@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Ringkasan data Si Basumba hari ini.</p>
    </div>
    <div class="d-flex gap-3">
        <button class="btn btn-secondary" onclick="window.print()">
            <i class="bi bi-download"></i> Export
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row">
    <div class="col-3">
        <div class="card stat-card">
            <div class="stat-header">
                <div class="stat-icon primary">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalKlien }}</div>
            <div class="stat-label">Total Klien Aktif</div>
        </div>
    </div>
    <div class="col-3">
        <div class="card stat-card">
            <div class="stat-header">
                <div class="stat-icon success">
                    <i class="bi bi-clipboard-check"></i>
                </div>
            </div>
            <div class="stat-value">{{ $wajibLaporHariIni }}</div>
            <div class="stat-label">Wajib Lapor Hari Ini</div>
        </div>
    </div>
    <div class="col-3">
        <div class="card stat-card">
            <div class="stat-header">
                <div class="stat-icon warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <div class="stat-value">{{ $wajibLaporMenunggu }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
    </div>
    <div class="col-3">
        <div class="card stat-card">
            <div class="stat-header">
                <div class="stat-icon info">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalLitmas }}</div>
            <div class="stat-label">Permohonan LITMAS</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-3">
        <div class="card stat-card">
            <div class="stat-header">
                <div class="stat-icon primary">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalAbh }}</div>
            <div class="stat-label">Pendampingan ABH</div>
        </div>
    </div>
    <div class="col-3">
        <div class="card stat-card">
            <div class="stat-header">
                <div class="stat-icon success">
                    <i class="bi bi-person-gear"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalPetugas }}</div>
            <div class="stat-label">Total PK/APK</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-8">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title">Wajib Lapor Mingguan</h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="laporanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title">Status Wajib Lapor</h3>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 250px;">
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #f59e0b"></span> Menunggu
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #10b981"></span> Disetujui
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #ef4444"></span> Ditolak
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Wajib Lapor Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Wajib Lapor Terbaru</h3>
        <a href="{{ route('admin.wajib-lapor.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Klien</th>
                    <th>Kategori</th>
                    <th>Status Bimbingan</th>
                    <th>PK/APK</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentWajibLapor as $lapor)
                <tr>
                    <td>{{ $lapor->tanggal_lapor->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex align-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($lapor->nama_lengkap) }}" class="avatar-sm" style="width: 24px; height: 24px; border-radius: 50%">
                            <span>{{ $lapor->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td>{{ ucfirst($lapor->kategori_klien) }}</td>
                    <td>{{ str_replace('_', ' ', ucfirst($lapor->status_bimbingan)) }}</td>
                    <td>{{ $lapor->petugas?->nama_lengkap ?? '-' }}</td>
                    <td>
                        @if($lapor->status_verifikasi == 'menunggu')
                            <span class="badge badge-warning">Menunggu</span>
                        @elseif($lapor->status_verifikasi == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.wajib-lapor.show', $lapor) }}" class="btn-icon" style="width: 28px; height: 28px;">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data wajib lapor</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctxLaporan = document.getElementById('laporanChart').getContext('2d');
    new Chart(ctxLaporan, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Wajib Lapor',
                data: {!! json_encode($chartData) !!},
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.05)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [{{ $statusMenunggu }}, {{ $statusDisetujui }}, {{ $statusDitolak }}],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush
