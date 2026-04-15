<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empuser extends Model
{
    protected $table = 'empusers';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];
    public $timestamps = false;
}
