@extends('layouts.admin')

@section('title', 'Pendampingan ABH')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pendampingan ABH</h1>
        <p class="page-subtitle">Kelola pendampingan Anak Berhadapan dengan Hukum</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="" method="GET" class="d-flex gap-3">
            <input type="text" name="search" class="form-control" placeholder="Cari perkara/penyidik..." value="{{ request('search') }}" style="max-width: 250px;">
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
                    <th>No. Surat</th>
                    <th>Instansi</th>
                    <th>Perkara</th>
                    <th>Penyidik</th>
                    <th>PK/APK</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($abh as $a)
                <tr>
                    <td>{{ $a->nomor_surat_permintaan }}</td>
                    <td>{{ $a->instansiKepolisian?->nama ?? '-' }}</td>
                    <td>{{ Str::limit($a->perkara_kasus, 50) }}</td>
                    <td>{{ $a->nama_penyidik }}</td>
                    <td>{{ $a->petugas?->nama_lengkap ?? '-' }}</td>
                    <td>
                        @if($a->status == 'menunggu')
                            <span class="badge badge-warning">Menunggu</span>
                        @elseif($a->status == 'diproses')
                            <span class="badge badge-info">Diproses</span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.abh.show', $a) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data pendampingan ABH</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($abh->hasPages())
    <div class="card-body">
        {{ $abh->links() }}
    </div>
    @endif
</div>
@endsection
