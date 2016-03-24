<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgrammingLanguage extends Model
{
    public function projects()
    {
    	return $this->belongsToMany('App\Project');
    }
}
