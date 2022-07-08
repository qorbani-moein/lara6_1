<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        //هر نقش میتواند به چندین کاربر تعلق بگیرد
//        return $this->belongsToMany(User::class);
        // زمانی که نام جدول دقیقا هم نام با رابطه ها نیست باید دستی مقدار دهی شود
        return $this->belongsToMany(User::class,'role_user2','role_id','user_id');
    }
}
