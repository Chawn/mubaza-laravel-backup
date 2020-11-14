<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOutline extends Model {

    public $timestamps = false;

    public $fillable = [
        'id',
        'outline_left', 'outline_top',
        'outline_height', 'outline_width'
    ];
    public function product() {
        return $this->belongsTo('app\Product', 'id');
    }

}
