<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posting extends Model
{
    use HasFactory;

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function getKomentar() {
        return $this->hasMany(komentar::class, 'id_post','id');
    }
}
