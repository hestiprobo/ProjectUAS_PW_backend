<?php

namespace App\Models;

use App\Models\posting as ModelsPosting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Posting;

class komentar extends Model
{
    use HasFactory;

    public function getPost()
    {
        return $this->hasOne(ModelsPosting::class, 'id', 'id_post');
    }

    public function getCommentedUser()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
