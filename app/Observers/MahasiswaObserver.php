<?php

namespace App\Observers;

use App\Models\Mahasiswa;
use App\Models\Notifikasi;

class MahasiswaObserver
{
    /**
     * Handle the Mahasiswa "created" event.
     */
    public function created(Mahasiswa $mahasiswa): void
    {
        // Create notification for new mahasiswa application
        Notifikasi::create([
            'judul' => 'Pengajuan Masuk',
            'pesan' => "Pengajuan baru dari {$mahasiswa->nama_lengkap} ({$mahasiswa->nama_instansi})",
            'tipe' => 'info',
            'telah_dibaca' => false,
            'tipe_peneliti' => 'mahasiswa',
            'mahasiswa_id' => $mahasiswa->id
        ]);
    }
}
