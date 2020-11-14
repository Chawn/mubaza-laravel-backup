<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {

    public $timestamps = false;
    public $fillable = [
        'name', 'detail'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }
}
