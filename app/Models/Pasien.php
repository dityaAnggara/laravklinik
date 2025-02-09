<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Daftarcheckup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pasien extends Authenticatable implements JWTSubject
{
    //
    use HasFactory, Notifiable;

    protected $table = 'pasiens';

    protected $fillable = [
        'nama',
        'email',
        'jk',
        'nik',
        'telepone',
        'password',
        'tanggal_lahir',
    ];
    //public function pasiendaftar()
    //{
    //    return $this->hasOne(Daftarcheckup::class);
    //}
    public function scopeSearch($query, $value)
    {
        $query->where('nama', 'like', "%{$value}%")->orwhere('nik', 'like', "%{$value}%");
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
