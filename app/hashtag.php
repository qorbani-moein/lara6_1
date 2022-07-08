<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hashtag extends Model
{
    public function comment()
    {
        return $this->belongsToMany(comment::class,'comment_hashtag','comment_id','hashtag_id');
    }
    public function user()
    {
        return $this->hasManyThrough( User::class ,Comment::class );
    }

}
