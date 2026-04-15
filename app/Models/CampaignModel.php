<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignContactListModel;


class CampaignModel extends Model
{
    protected $table = 'campaign';

    protected $fillable = [
        "name",
        "subject",
        "content",
        "status",
        "scheduled_at",
        "queue_name",
    ];

      public $timestamps = true;
    
     public function contactLists()
    {
        return $this->belongsToMany(
            ContactListModel::class, 'campaign_contact_list', 'campaign_id', 'contact_list_id');
    }

}
