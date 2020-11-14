<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewPath extends Model {

    public $fillable = [
        'path'
    ];
	//
    public function counts()
    {
        return $this->hasMany('view_counts');
    }
}
