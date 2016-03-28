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

    public function organizations()
    {
        return $this->belongsToMany('App\Organization');
    }

    public function coordinator()
    {
        return $this->belongsTo('App\User');
    }

    public function programmingLanguages()
    {
        return $this->belongsToMany('App\ProgrammingLanguage');
    }

}
