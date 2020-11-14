<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class UserProfile extends Model
{

    public $dates = ['birthday'];
    public $fillable = [
        'full_name', 'address', 'birthday',
        'building', 'district',
        'province', 'zipcode',
        'phone', 'id'
    ];

    public function getTwitterAttribute($value)
    {
        if(is_null($value) || $value == '')
        {
            return null;
        }

        if(str_contains($value, 'http'))
        {
            return $value;
        }

        return 'http://twitter.com/' . $value;
    }
    public function getFacebookAttribute($value)
    {
        if(is_null($value) || $value == '')
        {
            return null;
        }

        if(str_contains($value, 'http'))
        {
            return $value;
        }

        return 'http://facebook.com/' . $value;
    }
    public function getWebsiteAttribute($value)
    {
        if(is_null($value) || $value == '')
        {
            return null;
        }

        if(str_contains($value, 'http'))
        {
            return $value;
        }
        return 'http://' . $value;
    }
    public function getBirthdayAttribute($value) {
        return new Date($value);
    }
    public function user() {
        return $this->belongsTo('App\User', 'id');
    }
}
