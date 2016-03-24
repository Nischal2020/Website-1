<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Function that returns the course of the user
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function coordinates()
    {
        return $this->hasMany('App\Project');
    }
    public function events()
    {
        return $this->belongsToMany('App\Event');
    }
}
