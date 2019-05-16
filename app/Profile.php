<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        return '/storage/' . ($this->image ?  $this->image : 'profile/MiGIJjqpOjYrqt1H37tnReaLesl8LTkRSEKASOn9.png');
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
