<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'judul',
        'pesan',
        'tipe',
        'telah_dibaca',
        'tipe_peneliti',
        'user_id',
        'mahasiswa_id',
        'non_mahasiswa_id',
        'alasan_penolakan',
        'penerbitan_surat_id',
    ];

    /**
     * Get the user associated with the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the mahasiswa associated with the notification.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Get the non-mahasiswa associated with the notification.
     */
    public function nonMahasiswa(): BelongsTo
    {
        return $this->belongsTo(NonMahasiswa::class);
    }

    /**
     * Get the penerbitan surat associated with the notification.
     */
    public function penerbitanSurat(): BelongsTo
    {
        return $this->belongsTo(PenerbitanSurat::class);
    }
}