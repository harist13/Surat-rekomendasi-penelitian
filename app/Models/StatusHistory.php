<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusHistory extends Model
{
    use HasFactory;

    protected $table = 'status_history';

    protected $fillable = [
        'status',
        'notes',
        'tipe_peneliti',
        'mahasiswa_id',
        'non_mahasiswa_id',
        'user_id',
    ];

    /**
     * Get the mahasiswa associated with the status history.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Get the non-mahasiswa associated with the status history.
     */
    public function nonMahasiswa(): BelongsTo
    {
        return $this->belongsTo(NonMahasiswa::class);
    }

    /**
     * Get the user associated with the status history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}