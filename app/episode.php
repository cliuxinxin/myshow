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
}
