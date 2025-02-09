<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Obat as ModelObat;

class Resep extends Model
{
    //
    public function obat()
    {
        return $this->belongsTo(ModelObat::class);
    }

}
