<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignLike extends Model {
    public $fillable = [
        'campaign_id', 'user_id'
    ];

    public function campaign() {
        return $this->belongsTo('App\Campaign');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
}
