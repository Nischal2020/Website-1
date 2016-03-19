<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
 * O nome é no singular, assim o Laravel reconhece automaticamente a tabela 'projects'
 * criado com
 * php artisan make:model Project
 */
class Project extends Model
{


    /*
     * relação com o modelo "User" Many to Many
     * https://laravel.com/docs/5.2/eloquent-relationships#many-to-many
     *
     */

    public function organizations()
    {
        return $this->belongsToMany('App\Organization');
    }

    public function coordinator()
    {
        return $this->belongsTo('App\User');
    }

}
