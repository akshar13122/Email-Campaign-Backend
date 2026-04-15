<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignContactListModel extends Model
{
     protected $table = 'campaign_contact_list';

      protected $fillable = [
        "campaign_id",
        "contact_list_id"
    ];

     public $timestamps = true;
}
