<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serviceModel extends Model{
    protected $table = 'services';

    protected $fillable = [
        "service"
    ];

        public $timestamps = false;
}