<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Obat;

class Categorie extends Model
{
    //
    protected $fillable = ['kategori'];
    public function kategoriObatt()
    {
        return $this->hasMany(Obat::class, 'kategori_id');
    }
}
