<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	public $timestamps = FALSE;

    public $fillable = [
        'name'
    ];
}
