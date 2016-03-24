<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    public function events()
    {
    	return $this->belongsToMany('App\Event');
    }
}
