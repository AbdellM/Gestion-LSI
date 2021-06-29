<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prof extends User
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->hasMany(Module::class);
    }
}
