<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignType extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail', 'is_active'
    ];

    public function campaigns() {
        return $this->hasMany('App\Campaign');
    }
}
