<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddUserModel extends Model
{
     protected $table = 'campaign_user';

         protected $fillable = [
            "name",
            "email",
            "password",
            "status",    
    ];

    public $timestamps = true;
}
