<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model {
    public $fillable = [
        'follower_id', 'user_id'
    ];

    public function follower() {
        return $this->belongsTo('App\User', 'follower_id');
    }
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
