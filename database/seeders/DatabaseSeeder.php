<?php

namespace Database\Seeders;

use App\Models\AsalPermintaan;
use App\Models\InstansiKepolisian;
use App\Models\JenisLitmas;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@basumba.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Operator User
        User::create([
            'name' => 'Operator Bapas',
            'email' => 'operator@basumba.go.id',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        // Create sample PK
        $pkUser = User::create([
            'name' => 'Pembimbing Kemasyarakatan',
            'email' => 'pk@basumba.go.id',
            'password' => Hash::make('password'),
            'role' => 'pk',
        ]);

        Petugas::create([
            'user_id' => $pkUser->id,
            'nip' => '198501012010011001',
            'nama_lengkap' => 'Pembimbing Kemasyarakatan',
            'jabatan' => 'PK',
            'no_telepon' => '08123456789',
        ]);

        // Create sample APK
        $apkUser = User::create([
            'name' => 'Asisten PK',
            'email' => 'apk@basumba.go.id',
            'password' => Hash::make('password'),
            'role' => 'apk',
        ]);

        Petugas::create([
            'user_id' => $apkUser->id,
            'nip' => '199001012015011001',
            'nama_lengkap' => 'Asisten PK',
            'jabatan' => 'APK',
            'no_telepon' => '08198765432',
        ]);

        // Master Data - Asal Permintaan
        $asalPermintaan = [
            'Lapas Kelas IIA Sumbawa Besar',
            'Rutan Kelas IIB Sumbawa Besar',
            'Lapas Kelas III Dompu',
            'Pengadilan Negeri Sumbawa Besar',
        ];
        foreach ($asalPermintaan as $nama) {
            AsalPermintaan::create(['nama' => $nama]);
        }

        // Master Data - Jenis LITMAS
        $jenisLitmas = [
            'Pembebasan Bersyarat (PB)',
            'Cuti Bersyarat (CB)',
            'Cuti Menjelang Bebas (CMB)',
            'Asimilasi',
            'Cuti Mengunjungi Keluarga (CMK)',
        ];
        foreach ($jenisLitmas as $nama) {
            JenisLitmas::create(['nama' => $nama]);
        }

        // Master Data - Instansi Kepolisian
        $instansiKepolisian = [
            'Polres Sumbawa',
            'Polsek Sumbawa',
            'Polsek Unter Iwes',
            'Polsek Moyo Hilir',
            'Polsek Moyo Utara',
            'Polsek Lape',
            'Polsek Lopok',
        ];
        foreach ($instansiKepolisian as $nama) {
            InstansiKepolisian::create(['nama' => $nama]);
        }
    }
}
