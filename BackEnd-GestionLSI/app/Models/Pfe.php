<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfe extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function prof()
    {
        return $this->hasOne(Prof::class);
    }
}
