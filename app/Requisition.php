<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    /*
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
     *
     */
    public function materials()
    {
        return $this->belongsToMany('App\Material');
    }
}
