@extends('layouts.admin')

@section('title', 'Detail LITMAS')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Permohonan LITMAS</h1>
        <p class="page-subtitle">{{ $litma->nama_narapidana }} - {{ $litma->nomor_registrasi }}</p>
    </div>
    <a href="{{ route('admin.litmas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Narapidana</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table style="width: 100%;">
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Asal Permintaan</td><td>{{ $litma->asalPermintaan?->nama ?? '-' }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Jenis LITMAS</td><td>{{ $litma->jenisLitmas?->nama ?? '-' }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Nama Narapidana</td><td>{{ $litma->nama_narapidana }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">No. Registrasi</td><td>{{ $litma->nomor_registrasi }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Tindak Pidana/Pasal</td><td>{{ $litma->tindak_pidana_pasal }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Nomor Putusan</td><td>{{ $litma->nomor_putusan ?? '-' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table style="width: 100%;">
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Tanggal Putusan</td><td>{{ $litma->tanggal_putusan?->format('d/m/Y') ?? '-' }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Mulai Ditahan</td><td>{{ $litma->tanggal_mulai_ditahan?->format('d/m/Y') ?? '-' }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Lama Pidana</td><td>{{ $litma->lama_pidana ?? '-' }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">1/3 Masa Hukuman</td><td>{{ $litma->sepertiga_masa_hukuman?->format('d/m/Y') ?? '-' }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">2/3 Masa Hukuman</td><td>{{ $litma->duapertiga_masa_hukuman?->format('d/m/Y') ?? '-' }}</td></tr>
                            <tr><td style="padding: 8px 0; color: var(--text-muted);">Tanggal Ekspirasi</td><td>{{ $litma->tanggal_ekspirasi?->format('d/m/Y') ?? '-' }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Penjamin</h3>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr><td style="padding: 8px 0; width: 30%; color: var(--text-muted);">Nama Penjamin</td><td>{{ $litma->nama_penjamin ?? '-' }}</td></tr>
                    <tr><td style="padding: 8px 0; color: var(--text-muted);">Hubungan</td><td>{{ $litma->hubungan_penjamin ?? '-' }}</td></tr>
                    <tr><td style="padding: 8px 0; color: var(--text-muted);">No. Telepon</td><td>{{ $litma->telepon_penjamin ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Berkas</h3>
            </div>
            <div class="card-body">
                @if($litma->files->count() > 0)
                <div class="row">
                    @foreach($litma->files as $file)
                    <div class="col-6 mb-3">
                        <div style="background: var(--bg-secondary); padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <i class="bi bi-file-earmark"></i>
                                <span>{{ str_replace('_', ' ', ucfirst($file->jenis_file)) }}</span>
                            </div>
                            <a href="{{ route('admin.litmas.download-file', $file) }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted">Belum ada berkas yang diupload.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status & Penugasan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.litmas.update-status', $litma) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="menunggu" {{ $litma->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $litma->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $litma->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tugaskan ke PK/APK</label>
                        <select name="petugas_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach(\App\Models\Petugas::where('is_active', true)->get() as $p)
                                <option value="{{ $p->id }}" {{ $litma->petugas_id == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }} ({{ $p->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ $litma->catatan }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
