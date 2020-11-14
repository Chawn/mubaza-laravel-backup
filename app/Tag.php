<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	public $timestamps = false;
    public $fillable = [
      'name', 'description'
    ];

    public static function getHitTag()
    {
    }

    public function campaigns() {
        return $this->belongsToMany(Campaign::class);
    }
}
