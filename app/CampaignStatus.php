<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignStatus extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail', 'is_active'
    ];

    public function scopeStatus ($query, $status_name)
    {
        return $query->whereName($status_name);
    }

    public function scopeCheck ($query)
    {
        return $query->whereName('check');
    }
    
    public function scopeOpen ($query)
    {
        return $query->whereName('open');
    }

    public function scopeActive($query)
    {
        return $query->whereName('active');
    }

    public function scopeClose ($query)
    {
        return $query->whereName('close');
    }

    public function scopeCancel ($query)
    {
        return $query->whereName('cancel');
    }

    public function scopeUserDelete ($query)
    {
        return $query->wherename('user_delete');
    }

    public function campaigns() {
        return $this->hasMany('App\Campaign');
    }
}
