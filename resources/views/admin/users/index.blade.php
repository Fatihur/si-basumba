@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen User</h1>
        <p class="page-subtitle">Kelola akun pengguna sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah User
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="" method="GET" class="d-flex gap-3">
            <input type="text" name="search" class="form-control" placeholder="Cari nama/email..." value="{{ request('search') }}" style="max-width: 250px;">
            <select name="role" class="form-control" style="max-width: 150px;">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pk" {{ request('role') == 'pk' ? 'selected' : '' }}>PK</option>
                <option value="apk" {{ request('role') == 'apk' ? 'selected' : '' }}>APK</option>
                <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
            </select>
            <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i></button>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-center gap-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" style="width: 32px; height: 32px; border-radius: 50%">
                            <span>{{ $user->name }}</span>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge badge-info">{{ strtoupper($user->role) }}</span></td>
                    <td>
                        @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon" style="width: 28px; height: 28px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" style="width: 28px; height: 28px; color: #ef4444;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-body">{{ $users->links() }}</div>
    @endif
</div>
@endsection
