@extends('layouts.admin')

@section('title', 'Tambah Klien')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Klien</h1>
        <p class="page-subtitle">Tambah data klien baru</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.klien.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span style="color: #ef4444">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">No. WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" value="{{ old('no_wa') }}">
                        @error('no_wa')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Kategori <span style="color: #ef4444">*</span></label>
                        <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                            <option value="dewasa" {{ old('kategori') == 'dewasa' ? 'selected' : '' }}>Dewasa</option>
                            <option value="anak" {{ old('kategori') == 'anak' ? 'selected' : '' }}>Anak</option>
                        </select>
                        @error('kategori')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Status Bimbingan</label>
                        <select name="status_bimbingan" class="form-control @error('status_bimbingan') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="pembebasan_bersyarat" {{ old('status_bimbingan') == 'pembebasan_bersyarat' ? 'selected' : '' }}>Pembebasan Bersyarat</option>
                            <option value="cuti_bersyarat" {{ old('status_bimbingan') == 'cuti_bersyarat' ? 'selected' : '' }}>Cuti Bersyarat</option>
                            <option value="asimilasi" {{ old('status_bimbingan') == 'asimilasi' ? 'selected' : '' }}>Asimilasi</option>
                            <option value="cmd" {{ old('status_bimbingan') == 'cmd' ? 'selected' : '' }}>CMD</option>
                        </select>
                        @error('status_bimbingan')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">PK/APK</label>
                        <select name="petugas_id" class="form-control @error('petugas_id') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            @foreach($petugas as $p)
                                <option value="{{ $p->id }}" {{ old('petugas_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }} ({{ $p->jabatan }})</option>
                            @endforeach
                        </select>
                        @error('petugas_id')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai Bimbingan</label>
                        <input type="date" name="tanggal_mulai_bimbingan" class="form-control @error('tanggal_mulai_bimbingan') is-invalid @enderror" value="{{ old('tanggal_mulai_bimbingan') }}">
                        @error('tanggal_mulai_bimbingan')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai Bimbingan</label>
                        <input type="date" name="tanggal_selesai_bimbingan" class="form-control @error('tanggal_selesai_bimbingan') is-invalid @enderror" value="{{ old('tanggal_selesai_bimbingan') }}">
                        @error('tanggal_selesai_bimbingan')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check"></i> Simpan
                </button>
                <a href="{{ route('admin.klien.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
