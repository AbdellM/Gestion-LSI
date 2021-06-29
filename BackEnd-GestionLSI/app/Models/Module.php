<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function seance()
    {
        return $this->hasMany(Seance::class);
    }
}
