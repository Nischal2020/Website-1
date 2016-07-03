<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /*
     *
     */
    public function requisition()
    {
        return $this->belongsToMany('App\Requisition');
    }
}
