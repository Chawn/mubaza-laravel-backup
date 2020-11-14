<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignShippingStatus extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public function campaigns() {
        return $this->hasMany('App\Campaign');
    }
}
