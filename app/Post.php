<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //111222
    protected $table = 'post';
    protected $fillable = ['title','content'];

}
