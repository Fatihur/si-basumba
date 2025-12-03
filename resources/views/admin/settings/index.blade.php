@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pengaturan</h1>
        <p class="page-subtitle">Kelola pengaturan aplikasi</p>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-whatsapp" style="color: #25D366;"></i> Pengaturan WhatsApp</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp <span style="color: #ef4444">*</span></label>
                        <input type="text" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" 
                               value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '') }}" 
                               placeholder="6281234567890" required>
                        <small style="color: var(--text-muted);">Format: kode negara + nomor (contoh: 6281234567890)</small>
                        @error('whatsapp_number')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-info-circle"></i> Informasi</h3>
            </div>
            <div class="card-body">
                <p style="color: var(--text-muted); margin-bottom: 16px;">
                    Nomor WhatsApp ini akan ditampilkan di aplikasi mobile sebagai tombol kontak untuk masyarakat yang ingin menghubungi Bapas Sumbawa Besar.
                </p>
                <div style="background: #ecfdf5; border: 1px solid #10b981; border-radius: 8px; padding: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #065f46;">
                        <i class="bi bi-lightbulb"></i>
                        <strong>Tips:</strong>
                    </div>
                    <ul style="margin: 8px 0 0 24px; color: #065f46; font-size: 13px;">
                        <li>Gunakan format internasional tanpa tanda + atau spasi</li>
                        <li>Contoh: 6281234567890</li>
                        <li>Pastikan nomor aktif dan dapat menerima pesan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
