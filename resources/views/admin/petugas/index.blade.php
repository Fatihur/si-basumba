@extends('layouts.admin')

@section('title', 'Data PK/APK')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data PK/APK</h1>
        <p class="page-subtitle">Kelola data Pembimbing Kemasyarakatan</p>
    </div>
    <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Petugas
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="" method="GET" class="d-flex gap-3">
            <input type="text" name="search" class="form-control" placeholder="Cari nama/NIP..." value="{{ request('search') }}" style="max-width: 250px;">
            <select name="jabatan" class="form-control" style="max-width: 150px;">
                <option value="">Semua Jabatan</option>
                <option value="PK" {{ request('jabatan') == 'PK' ? 'selected' : '' }}>PK</option>
                <option value="APK" {{ request('jabatan') == 'APK' ? 'selected' : '' }}>APK</option>
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
                    <th>NIP</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th>No. Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugas as $p)
                <tr>
                    <td>{{ $p->nip }}</td>
                    <td>
                        <div class="d-flex align-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama_lengkap) }}" style="width: 32px; height: 32px; border-radius: 50%">
                            <div>
                                <div>{{ $p->nama_lengkap }}</div>
                                <small style="color: var(--text-muted)">{{ $p->user?->email ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge {{ $p->jabatan == 'PK' ? 'badge-info' : 'badge-warning' }}">{{ $p->jabatan }}</span></td>
                    <td>{{ $p->no_telepon ?? '-' }}</td>
                    <td>
                        @if($p->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.petugas.edit', $p) }}" class="btn-icon" style="width: 28px; height: 28px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.petugas.destroy', $p) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" style="width: 28px; height: 28px; color: #ef4444;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data petugas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($petugas->hasPages())
    <div class="card-body">{{ $petugas->links() }}</div>
    @endif
</div>
@endsection
