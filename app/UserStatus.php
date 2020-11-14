<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public static function scopeInActive ($query)
    {
        return $query->where('name', 'inactive');
    }

    public function scopeNormal ($query)
    {
        return $query->where('name', 'normal');
    }

    public function scopeBanned ($query)
    {
        return $query->where('name', 'banned');
    }

    public function users() {
        return $this->hasMany('App\User');
    }
}
