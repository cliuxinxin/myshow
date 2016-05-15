<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class episode extends Model
{
    //
    protected $fillable=[
        'show',
        'episode',
        'season',
        'name',
        'date',
        'url'
    ];


    /**
     * Episode seen by user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App/User');
    }
}
