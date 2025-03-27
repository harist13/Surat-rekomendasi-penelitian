<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'no_pengajuan',
        'nama_lengkap',
        'nim',
        'email',
        'no_hp',
        'alamat_peneliti',
        'nama_instansi',
        'alamat_instansi',
        'jurusan',
        'judul_penelitian',
        'lama_penelitian',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi_penelitian',
        'tujuan_penelitian',
        'anggota_peneliti',
        'surat_pengantar_instansi',
        'proposal_penelitian',
        'ktp',
        'status',
    ];

    public function penerbitanSurats(): HasMany
    {
        return $this->hasMany(PenerbitanSurat::class);
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(StatusHistory::class);
    }
}