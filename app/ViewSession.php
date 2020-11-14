<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewSession extends Model {

    public $fillable = [
        'session_id'
    ];
	//
    public function counts()
    {
        return $this->hasMany('view_counts');
    }
}
