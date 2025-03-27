<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    protected $fillable = [
        'nip',
        'username',
        'password',
        'no_telp',
        'email',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function penerbitanSurats(): HasMany
    {
        return $this->hasMany(PenerbitanSurat::class);
    }
}