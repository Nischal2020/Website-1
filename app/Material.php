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
        return $this->belongsTo('App\Requisition');
    }
}
