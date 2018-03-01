<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function linkeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
