@extends('layouts.admin')

@section('title', 'Detail ABH')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Pendampingan ABH</h1>
        <p class="page-subtitle">{{ $abh->nomor_surat_permintaan }}</p>
    </div>
    <a href="{{ route('admin.abh.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Permohonan</h3>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr><td style="padding: 8px 0; width: 30%; color: var(--text-muted);">Instansi Kepolisian</td><td>{{ $abh->instansiKepolisian?->nama ?? '-' }}</td></tr>
                    <tr><td style="padding: 8px 0; color: var(--text-muted);">Nomor Surat</td><td>{{ $abh->nomor_surat_permintaan }}</td></tr>
                    <tr><td style="padding: 8px 0; color: var(--text-muted);">Tanggal Surat</td><td>{{ $abh->tanggal_surat_permintaan->format('d/m/Y') }}</td></tr>
                    <tr><td style="padding: 8px 0; color: var(--text-muted);">Perkara/Kasus</td><td>{{ $abh->perkara_kasus }}</td></tr>
                    <tr><td style="padding: 8px 0; color: var(--text-muted);">Nama Penyidik</td><td>{{ $abh->nama_penyidik }}</td></tr>
                    <tr><td style="padding: 8px 0; color: var(--text-muted);">Telepon Penyidik</td><td>{{ $abh->telepon_penyidik }}</td></tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Berkas</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div style="background: var(--bg-secondary); padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <i class="bi bi-file-earmark"></i>
                                <span>Surat Permintaan</span>
                            </div>
                            <a href="{{ asset('storage/' . $abh->file_surat_permintaan) }}" target="_blank" class="btn btn-sm btn-secondary">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                    @if($abh->file_bap)
                    <div class="col-6 mb-3">
                        <div style="background: var(--bg-secondary); padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <i class="bi bi-file-earmark"></i>
                                <span>Berkas BAP</span>
                            </div>
                            <a href="{{ asset('storage/' . $abh->file_bap) }}" target="_blank" class="btn btn-sm btn-secondary">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status & Penugasan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.abh.update-status', $abh) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="menunggu" {{ $abh->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ $abh->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $abh->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tugaskan ke PK/APK</label>
                        <select name="petugas_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach(\App\Models\Petugas::where('is_active', true)->get() as $p)
                                <option value="{{ $p->id }}" {{ $abh->petugas_id == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }} ({{ $p->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ $abh->catatan }}</textarea>
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
