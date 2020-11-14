<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model {
    public $fillable = [
        'comment_id', 'user_id'
    ];

    public function comment() {
        return $this->belongsTo('App\Comment');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }
}
