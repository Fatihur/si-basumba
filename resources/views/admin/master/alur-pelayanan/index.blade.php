@extends('layouts.admin')

@section('title', 'Alur Pelayanan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Alur Pelayanan</h1>
        <p class="page-subtitle">Kelola informasi alur pelayanan untuk mobile app</p>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Tambah Alur</h3></div>
            <div class="card-body">
                <form action="{{ route('admin.alur-pelayanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group"><label class="form-label">Judul <span style="color: #ef4444">*</span></label><input type="text" name="judul" class="form-control" required></div>
                    <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3"></textarea></div>
                    <div class="form-group"><label class="form-label">Gambar</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
                    <div class="form-group"><label class="form-label">Urutan <span style="color: #ef4444">*</span></label><input type="number" name="urutan" class="form-control" value="0" required></div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus"></i> Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Urutan</th><th>Judul</th><th>Gambar</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $item->urutan }}</td>
                            <td>
                                <div><strong>{{ $item->judul }}</strong></div>
                                <small style="color: var(--text-muted);">{{ Str::limit($item->deskripsi, 50) }}</small>
                            </td>
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                @else
                                    -
                                @endif
                            </td>
                            <td><span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">{{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}</span></td>
                            <td>
                                <form action="{{ route('admin.alur-pelayanan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon" style="width: 28px; height: 28px; color: #ef4444;"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($data->hasPages())<div class="card-body">{{ $data->links() }}</div>@endif
        </div>
    </div>
</div>
@endsection
