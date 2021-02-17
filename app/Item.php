<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'GCP.dbo.GCP LIVE$Item';
    public function itemVariants(){
    	return $this->hasMany('App\ItemVariant','Item No_','No_');
    }
}
