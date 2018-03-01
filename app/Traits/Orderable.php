<?php

namespace App\Traits;

trait Orderable
{
    public function scopeLastFirst($query)
    {
        return $query->orderBy('created_at','desc');
    }

    public function scopeOldestFirst($query)
    {
        return $query->orderBy('created_at','asc');
    }
}
