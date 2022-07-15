<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->hasOne(post::class);
    }

    public function posts()
    {
        return $this->hasMany(post::class);
    }

    public function roles()
    {
        //هر کاربر میتواند چند نقش بگیرد
        return $this->belongsToMany(Role::class);
        // زمانی که نام جدول دقیقا هم نام با رابطه ها نیست باید دستی مقدار دهی شود
//        return $this->belongsToMany(User::class,'role_user2','user_id','role_id');
    }

    public function hashtag()
    {
        return $this->hasManyThrough(hashtag::class,Comment::class);
    }

}
