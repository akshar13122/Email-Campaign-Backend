<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empuser;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'assignee',
    ];
    public $timestamps = false;

    public function user(){
       return $this->belongsTo(Empuser::class,'assignee','id');
    }
}
