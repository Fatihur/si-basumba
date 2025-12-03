@extends('layouts.admin')

@section('title', 'Instansi Kepolisian')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Instansi Kepolisian</h1>
        <p class="page-subtitle">Kelola data instansi kepolisian untuk ABH</p>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Tambah Data</h3></div>
            <div class="card-body">
                <form action="{{ route('admin.instansi-kepolisian.store') }}" method="POST">
                    @csrf
                    <div class="form-group"><label class="form-label">Nama <span style="color: #ef4444">*</span></label><input type="text" name="nama" class="form-control" required></div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus"></i> Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>No</th><th>Nama</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @forelse($data as $index => $item)
                        <tr>
                            <td>{{ $data->firstItem() + $index }}</td>
                            <td>{{ $item->nama }}</td>
                            <td><span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">{{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn-icon" style="width: 28px; height: 28px;" onclick="editItem({{ $item->id }}, '{{ $item->nama }}', {{ $item->is_active ? 'true' : 'false' }})"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.instansi-kepolisian.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button type="submit" class="btn-icon" style="width: 28px; height: 28px; color: #ef4444;"><i class="bi bi-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($data->hasPages())<div class="card-body">{{ $data->links() }}</div>@endif
        </div>
    </div>
</div>

<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: var(--bg-primary); padding: 24px; border-radius: 12px; width: 400px;">
        <h3 style="margin-bottom: 16px;">Edit Data</h3>
        <form id="editForm" method="POST">@csrf @method('PUT')
            <div class="form-group"><label class="form-label">Nama</label><input type="text" name="nama" id="editNama" class="form-control" required></div>
            <div class="form-group"><label class="form-label">Status</label><select name="is_active" id="editStatus" class="form-control"><option value="1">Aktif</option><option value="0">Non-Aktif</option></select></div>
            <div class="d-flex gap-3"><button type="submit" class="btn btn-primary">Simpan</button><button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button></div>
        </form>
    </div>
</div>

<script>
function editItem(id, nama, isActive) { document.getElementById('editForm').action = '{{ url("admin/instansi-kepolisian") }}/' + id; document.getElementById('editNama').value = nama; document.getElementById('editStatus').value = isActive ? '1' : '0'; document.getElementById('editModal').style.display = 'flex'; }
function closeModal() { document.getElementById('editModal').style.display = 'none'; }
</script>
@endsection
