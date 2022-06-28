<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //111111
    protected $table = 'post';
    protected $fillable = ['title','content'];

}
