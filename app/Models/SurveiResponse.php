<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveiResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'nama',
        'email',
        'no_hp',
        'jenis_kelamin',
        'usia',
        'rating',
        'kritik_saran',
        'jenis_layanan'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveiQuestion::class, 'question_id');
    }
}