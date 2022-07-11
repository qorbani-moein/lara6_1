<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //Recycle Bin

class Post extends Model
{
    //Recycle Bin
    use SoftDeletes;
    protected $date = ['deleted_at'];
    //111222
    protected $table = 'post';
    protected $fillable = ['title','content'];

    public function user()
    {
        //این کلاس متعلق است به کلاس یوزر
        return $this->belongsTo(User::class);
    }

}
