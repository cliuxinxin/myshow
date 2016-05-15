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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User follow many shows
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shows()
    {
        return $this->belongsToMany('App\Show')->withTimestamps();
    }

    /**
     * User have seen episode
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function episodes()
    {
        return $this->belongsToMany('App\Episode')->withTimestamps();
    }
}
