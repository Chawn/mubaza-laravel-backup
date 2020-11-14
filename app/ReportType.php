<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportType extends Model {

	public $timestamps = FALSE;

    public $fillable = [
        'name', 'detail'
    ];

    public function reports()
    {
    	return $this->hasMany('App\Report') ;
    }
}
