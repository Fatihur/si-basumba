@extends('layouts.admin')

@section('title', 'Permohonan LITMAS')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Permohonan LITMAS</h1>
        <p class="page-subtitle">Kelola permohonan penelitian kemasyarakatan</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="" method="GET" class="d-flex gap-3">
            <input type="text" name="search" class="form-control" placeholder="Cari nama/registrasi..." value="{{ request('search') }}" style="max-width: 250px;">
            <select name="status" class="form-control" style="max-width: 150px;">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
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
                    <th>No. Registrasi</th>
                    <th>Nama Narapidana</th>
                    <th>Asal Permintaan</th>
                    <th>Jenis LITMAS</th>
                    <th>PK/APK</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($litmas as $l)
                <tr>
                    <td>{{ $l->nomor_registrasi }}</td>
                    <td>{{ $l->nama_narapidana }}</td>
                    <td>{{ $l->asalPermintaan?->nama ?? '-' }}</td>
                    <td>{{ $l->jenisLitmas?->nama ?? '-' }}</td>
                    <td>{{ $l->petugas?->nama_lengkap ?? '-' }}</td>
                    <td>
                        @if($l->status == 'menunggu')
                            <span class="badge badge-warning">Menunggu</span>
                        @elseif($l->status == 'diproses')
                            <span class="badge badge-info">Diproses</span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.litmas.show', $l) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data permohonan LITMAS</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($litmas->hasPages())
    <div class="card-body">
        {{ $litmas->links() }}
    </div>
    @endif
</div>
@endsection
