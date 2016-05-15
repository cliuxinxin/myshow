<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class show extends Model
{
    protected $fillable = [
        'name',
        'type',
        'url',
        'update_date'
    ];

    protected $date=[
        'update_date'
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
