@extends('layouts.admin')

@section('title', 'Edit Petugas')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Petugas</h1>
        <p class="page-subtitle">{{ $petuga->nama_lengkap }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.petugas.update', $petuga) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">NIP <span style="color: #ef4444">*</span></label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $petuga->nip) }}" required>
                        @error('nip')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span style="color: #ef4444">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $petuga->nama_lengkap) }}" required>
                        @error('nama_lengkap')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Jabatan <span style="color: #ef4444">*</span></label>
                        <select name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" required>
                            <option value="PK" {{ old('jabatan', $petuga->jabatan) == 'PK' ? 'selected' : '' }}>PK</option>
                            <option value="APK" {{ old('jabatan', $petuga->jabatan) == 'APK' ? 'selected' : '' }}>APK</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $petuga->no_telepon) }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ old('is_active', $petuga->is_active) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !old('is_active', $petuga->is_active) ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
