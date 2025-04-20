<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveiQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pertanyaan',
        'kepuasan_pelayanan',
        'is_active'
    ];

    public function responses(): HasMany
    {
        return $this->hasMany(SurveiResponse::class, 'question_id');
    }
}