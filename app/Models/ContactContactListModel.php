<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ContactModel;
use App\Models\ContactListModel;

class ContactContactListModel extends Model
{
    protected $table =  'contact_contact_list';

    protected $fillable = [
         'contact_id',
        'contact_list_id'
    ];
        public $timestamps = false; 

    // contact  Relation
    // From ContactModel this will take all data which id = contact_id
    public function contact(){
        return $this->belongsTo(ContactModel::class,'contact_id','id');
    }

     // contact List Relation
     // From ContactListModel this will take all data which id = contact_list_id
    public function contactList(){  
        return $this->belongsTo(ContactListModel::class,'contact_list_id','id');
    }
}
