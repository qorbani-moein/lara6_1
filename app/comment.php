<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    public function hashtag()
    {
        return $this->belongsToMany(hashtag::class,'comment_hashtag','hashtag_id','comment_id');
    }
}
