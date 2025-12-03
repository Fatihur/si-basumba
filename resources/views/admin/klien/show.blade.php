@extends('layouts.admin')

@section('title', 'Detail Klien')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Klien</h1>
        <p class="page-subtitle">{{ $klien->nama_lengkap }}</p>
    </div>
    <div class="d-flex gap-3">
        <a href="{{ route('admin.klien.edit', $klien) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.klien.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 8px 0; width: 40%; color: var(--text-muted);">Nama Lengkap</td>
                        <td style="padding: 8px 0;">{{ $klien->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Email</td>
                        <td style="padding: 8px 0;">{{ $klien->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">No. WhatsApp</td>
                        <td style="padding: 8px 0;">{{ $klien->no_wa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Kategori</td>
                        <td style="padding: 8px 0;">{{ ucfirst($klien->kategori) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Status Bimbingan</td>
                        <td style="padding: 8px 0;">{{ $klien->status_bimbingan ? str_replace('_', ' ', ucfirst($klien->status_bimbingan)) : '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 8px 0; width: 40%; color: var(--text-muted);">PK/APK</td>
                        <td style="padding: 8px 0;">{{ $klien->petugas?->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Mulai Bimbingan</td>
                        <td style="padding: 8px 0;">{{ $klien->tanggal_mulai_bimbingan?->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Selesai Bimbingan</td>
                        <td style="padding: 8px 0;">{{ $klien->tanggal_selesai_bimbingan?->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Status</td>
                        <td style="padding: 8px 0;">
                            @if($klien->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Non-Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-muted);">Alamat</td>
                        <td style="padding: 8px 0;">{{ $klien->alamat ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
