<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Pasien;
use App\Models\User;

class Daftarcheckup extends Model
{
    //
    protected $fillable = ['pasien_id', 'dokter_id', 'status','tanggalcheckups'];

    public function pasien(): BelongsTo
    {
        
        return $this->belongsTo(Pasien::class);
    }
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
