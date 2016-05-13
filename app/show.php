<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class show extends Model
{
    protected $fillable = [
        'name',
        'type'
    ];

    /**
     * shows belong to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany('App/User');
    }


}
