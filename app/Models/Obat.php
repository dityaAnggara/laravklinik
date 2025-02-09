<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Satuan;
use App\Models\Categorie;
use App\Models\Price;


class Obat extends Model
{
    protected $fillable = ['obat', 'pemakaian', 'kategori_id', 'satuan_id', 'harga', 'berat'];

    public function kategori()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
    public function HargaObat()
    {
        return $this->hasMany(Price::class);
    }
}
