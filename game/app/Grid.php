<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    protected $table = 'universe';
    protected $fillable = [
        'id', 'x', 'y', 'data',
    ];
    public $timestamps = false;
}
