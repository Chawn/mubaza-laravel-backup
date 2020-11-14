<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignCategory extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail', 'is_active'
    ];

    public function scopeActive ($query)
    {
        return $query->where('is_active', true);
    }
    public function campaigns() {
        return $this->hasMany('App\Campaign');
    }
}
