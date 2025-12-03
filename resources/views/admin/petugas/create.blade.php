@extends('layouts.admin')

@section('title', 'Tambah Petugas')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Petugas</h1>
        <p class="page-subtitle">Tambah data PK/APK baru</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.petugas.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">NIP <span style="color: #ef4444">*</span></label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" required>
                        @error('nip')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span style="color: #ef4444">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Jabatan <span style="color: #ef4444">*</span></label>
                        <select name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" required>
                            <option value="PK" {{ old('jabatan') == 'PK' ? 'selected' : '' }}>PK (Pembimbing Kemasyarakatan)</option>
                            <option value="APK" {{ old('jabatan') == 'APK' ? 'selected' : '' }}>APK (Asisten PK)</option>
                        </select>
                        @error('jabatan')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon') }}">
                        @error('no_telepon')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <hr style="margin: 24px 0;">
            <h4 style="margin-bottom: 16px;">Akun Login</h4>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Email <span style="color: #ef4444">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Password <span style="color: #ef4444">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="text-danger" style="font-size: 12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password <span style="color: #ef4444">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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
