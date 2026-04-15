<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactListModel extends Model
{
    protected $table = 'contact_list';

    protected $fillable = [
        "list_name","description"
    ];

    public $timestamps = false;

      public function contactLists()
    {
        return $this->belongsToMany(
            ContactListModel::class,
            'campaign_contact_list',
            'campaign_id',
            'contact_list_id'
        );
    }
}
