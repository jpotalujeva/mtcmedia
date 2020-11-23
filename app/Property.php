<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    protected $table = 'properties';
    public $timestamps = true;

    protected $casts = [
        'price' => 'float'
    ];
    protected $guarded = ['*'];
    protected $fillable = ['*'];
}
