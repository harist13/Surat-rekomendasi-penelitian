<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerbitanSurat extends Model
{
    use HasFactory;

    protected $table = 'penerbitan_surat';

    protected $fillable = [
        'jenis_surat',
        'nomor_surat',
        'menimbang',
        'status_penelitian',
        'status_surat',
        'posisi_surat',
        'file_path',
        'user_id',
        'mahasiswa_id',
        'non_mahasiswa_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function nonMahasiswa(): BelongsTo
    {
        return $this->belongsTo(NonMahasiswa::class);
    }
}
