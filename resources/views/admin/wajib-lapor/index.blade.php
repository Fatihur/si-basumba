@extends('layouts.admin')

@section('title', 'Wajib Lapor')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Monitoring Wajib Lapor</h1>
        <p class="page-subtitle">Kelola data wajib lapor klien</p>
    </div>
    <a href="{{ route('admin.wajib-lapor.export') }}" class="btn btn-secondary">
        <i class="bi bi-download"></i> Export CSV
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="" method="GET" class="d-flex gap-3">
            <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}" style="max-width: 200px;">
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" style="max-width: 180px;">
            <select name="status" class="form-control" style="max-width: 150px;">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i></button>
        </form>
    </div>
</div>

<div class="card">
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
                @forelse($wajibLapor as $lapor)
                <tr>
                    <td>{{ $lapor->tanggal_lapor->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex align-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($lapor->nama_lengkap) }}" style="width: 32px; height: 32px; border-radius: 50%">
                            <div>
                                <div>{{ $lapor->nama_lengkap }}</div>
                                <small style="color: var(--text-muted)">{{ $lapor->email }}</small>
                            </div>
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
                        <a href="{{ route('admin.wajib-lapor.show', $lapor) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detail
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
    @if($wajibLapor->hasPages())
    <div class="card-body">
        {{ $wajibLapor->links() }}
    </div>
    @endif
</div>
@endsection
