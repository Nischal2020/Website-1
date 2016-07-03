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
        'username', 'email', 'password', 'course_id', 'role_id', 'student_id', 'name', 'avatar', 'version_control', 'about'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*//Function that returns the course of the user
    public function course()
    {
        return $this->belongsTo('App\Course');
    }*/

    //Function that returns the course of the user
    public function studies()
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

    public function programmingLanguages()
    {
        return $this->belongsToMany('App\ProgrammingLanguage');
    }
    
    public function has()
    {
        return $this->belongsTo('App\Role');
    }
    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }
    public function organizations()
    {
        return $this->belongsToMany('App\Organization');
    }

    /*public function requisitions()
    {
        return $this->hasMany('App\Requisition');
    }*/

    public function does()
    {
        return $this->hasMany('App\Requisition');
    }
}
