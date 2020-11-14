<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model {

    public $timestamps = false;
    public $fillable = [
        'id', 'full_detail',
        's_width', 's_height',
        'm_width', 'm_height',
        'l_width', 'l_height',
        'xl_width', 'xl_height',
        'xxl_width', 'xxl_height',
    ];
    public function product() {
        return $this->belongsTo('App\Product', 'product_id');
    }

}
