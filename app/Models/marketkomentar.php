<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marketkomentar extends Model
{
    use HasFactory;

    public function getMarket()
    {
        return $this->hasOne(marketplace::class, 'id', 'id_market');
    }

    public function getCommentedUser()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
