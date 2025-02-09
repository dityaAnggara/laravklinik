<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Obat;

class Satuan extends Model
{
    //
    protected $fillable = ['nama'];
    public function satuanObat()
    {
        return $this->hasMany(Obat::class);
    }
}
