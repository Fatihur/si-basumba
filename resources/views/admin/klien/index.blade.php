@extends('layouts.admin')

@section('title', 'Data Klien')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data Klien</h1>
        <p class="page-subtitle">Kelola data klien Bapas Sumbawa Besar</p>
    </div>
    <a href="{{ route('admin.klien.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Klien
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form action="" method="GET" class="d-flex gap-3">
            <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}" style="max-width: 300px;">
            <select name="kategori" class="form-control" style="max-width: 150px;">
                <option value="">Semua Kategori</option>
                <option value="anak" {{ request('kategori') == 'anak' ? 'selected' : '' }}>Anak</option>
                <option value="dewasa" {{ request('kategori') == 'dewasa' ? 'selected' : '' }}>Dewasa</option>
            </select>
            <select name="status" class="form-control" style="max-width: 150px;">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
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
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Kategori</th>
                    <th>Status Bimbingan</th>
                    <th>PK/APK</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($klien as $index => $k)
                <tr>
                    <td>{{ $klien->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama_lengkap) }}" style="width: 32px; height: 32px; border-radius: 50%">
                            <div>
                                <div>{{ $k->nama_lengkap }}</div>
                                <small style="color: var(--text-muted)">{{ $k->email ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ ucfirst($k->kategori) }}</td>
                    <td>{{ $k->status_bimbingan ? str_replace('_', ' ', ucfirst($k->status_bimbingan)) : '-' }}</td>
                    <td>{{ $k->petugas?->nama_lengkap ?? '-' }}</td>
                    <td>
                        @if($k->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.klien.show', $k) }}" class="btn-icon" style="width: 28px; height: 28px;" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.klien.edit', $k) }}" class="btn-icon" style="width: 28px; height: 28px;" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.klien.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" style="width: 28px; height: 28px; color: #ef4444;" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data klien</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($klien->hasPages())
    <div class="card-body">
        {{ $klien->links() }}
    </div>
    @endif
</div>
@endsection
