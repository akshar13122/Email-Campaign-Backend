<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ContactModel;

class CampaignRecipientModel extends Model
{
     protected $table = 'campaign_recipient';
     
      protected $fillable = [
        "campaign_id",
        "contact_id",
        "status",
        "sent_at"
    ];

     public $timestamps = true;
     public function contact(){
    return $this->belongsTo(ContactModel::class, 'contact_id');
}
}
