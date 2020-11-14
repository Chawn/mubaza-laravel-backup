<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class UserOption extends Model
{
    public $fillable = [
        'id', 'show_full_name', 'show_sex', 'show_birthday', 'show_email', 'show_address', 'show_phone',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'id');
    }
}
