<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Obat;

class Price extends Model
{
    //
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
