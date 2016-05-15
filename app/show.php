<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class show extends Model
{
    protected $fillable = [
        'name',
        'type',
        'url'
    ];

    /**
     * shows belong to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App/User');
    }


}
