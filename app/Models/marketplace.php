<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marketplace extends Model
{
    use HasFactory;

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function getKomentar()
    {
        return $this->hasMany(marketkomentar::class, 'id_market', 'id');
    }
}
