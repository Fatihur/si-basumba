@extends('layouts.admin')

@section('title', 'Detail Wajib Lapor')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Wajib Lapor</h1>
        <p class="page-subtitle">{{ $wajibLapor->nama_lengkap }} - {{ $wajibLapor->tanggal_lapor->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('admin.wajib-lapor.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Laporan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <table style="width: 100%;">
                            <tr>
                                <td style="padding: 8px 0; width: 40%; color: var(--text-muted);">Tanggal Lapor</td>
                                <td style="padding: 8px 0;">{{ $wajibLapor->tanggal_lapor->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; color: var(--text-muted);">Nama Lengkap</td>
                                <td style="padding: 8px 0;">{{ $wajibLapor->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; color: var(--text-muted);">Email</td>
                                <td style="padding: 8px 0;">{{ $wajibLapor->email }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; color: var(--text-muted);">No. WhatsApp</td>
                                <td style="padding: 8px 0;">{{ $wajibLapor->no_wa }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table style="width: 100%;">
                            <tr>
                                <td style="padding: 8px 0; width: 40%; color: var(--text-muted);">Kategori</td>
                                <td style="padding: 8px 0;">{{ ucfirst($wajibLapor->kategori_klien) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; color: var(--text-muted);">Status Bimbingan</td>
                                <td style="padding: 8px 0;">{{ str_replace('_', ' ', ucfirst($wajibLapor->status_bimbingan)) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; color: var(--text-muted);">PK/APK</td>
                                <td style="padding: 8px 0;">{{ $wajibLapor->petugas?->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; color: var(--text-muted);">Alamat</td>
                                <td style="padding: 8px 0;">{{ $wajibLapor->alamat }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verifikasi Form -->
        @if($wajibLapor->status_verifikasi == 'menunggu')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Verifikasi</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.wajib-lapor.verify', $wajibLapor) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Status Verifikasi</label>
                        <select name="status_verifikasi" class="form-control" required>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan_verifikasi" class="form-control" rows="3" placeholder="Catatan verifikasi (opsional)"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Verifikasi
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status Verifikasi</h3>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 8px 0; width: 30%; color: var(--text-muted);">Status</td>
                        <td style="padding: 8px 0;">
                            @if($wajibLapor->status_verifikasi == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Diverifikasi Oleh</td>
                        <td style="padding: 8px 0;">{{ $wajibLapor->verifiedByUser?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Waktu Verifikasi</td>
                        <td style="padding: 8px 0;">{{ $wajibLapor->verified_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Catatan</td>
                        <td style="padding: 8px 0;">{{ $wajibLapor->catatan_verifikasi ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Foto Selfie</h3>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $wajibLapor->foto_selfie) }}" alt="Foto Selfie" style="max-width: 100%; border-radius: 8px;">
            </div>
        </div>
    </div>
</div>
@endsection
