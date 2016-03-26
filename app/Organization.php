<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function projects()
    {
    	return $this->belongsToMany('App\Project');
    }
    public function associates() // no Trello está "associate", seria "associates"
    {
    	return $this->belongsToMany('App\Event');
    }
}
