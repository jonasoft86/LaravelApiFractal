<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    //protected $appends = ['avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    public function getAvatarAttribute()
    {
        return $this->avatar();
    }
    */

    public function hasLikedPost(Post $post)
    {
        //dd($post);
        return $post->likes->where('user_id',$this->id)->count()===1;
    }

    public function avatar()
    {
        return 'https://www.gravatars.com/'.md5($this->email).'?s=45&d=mm';
    }
}
