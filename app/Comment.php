<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    public $timestamps = true;
	public $fillable = [
        'user_id', 'campaign_id',
        'message'
    ];

    public function isLiked (User $user)
    {

    }

    public function campaign() {
        return $this->belongsTo('App\Campaign', 'campaign_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function likes() {
        return $this->hasMany('App\CommentLike');
    }
}
