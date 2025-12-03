<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = Petugas::with('user');

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                ->orWhere('nip', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        $petugas = $query->orderBy('nama_lengkap')->paginate(10);

        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:petugas,nip',
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|in:PK,APK',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $role = $validated['jabatan'] === 'PK' ? 'pk' : 'apk';

        $user = User::create([
            'name' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        Petugas::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'jabatan' => $validated['jabatan'],
            'no_telepon' => $validated['no_telepon'],
        ]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan.');
    }

    public function show(Petugas $petuga)
    {
        $petuga->load('user', 'klien', 'wajibLapor', 'litmas', 'abh');
        return view('admin.petugas.show', compact('petuga'));
    }

    public function edit(Petugas $petuga)
    {
        return view('admin.petugas.edit', compact('petuga'));
    }

    public function update(Request $request, Petugas $petuga)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:petugas,nip,' . $petuga->id,
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|in:PK,APK',
            'no_telepon' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $petuga->update($validated);

        if ($petuga->user) {
            $petuga->user->update([
                'name' => $validated['nama_lengkap'],
                'role' => $validated['jabatan'] === 'PK' ? 'pk' : 'apk',
                'is_active' => $validated['is_active'] ?? true,
            ]);
        }

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(Petugas $petuga)
    {
        if ($petuga->user) {
            $petuga->user->delete();
        }
        $petuga->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil dihapus.');
    }
}
