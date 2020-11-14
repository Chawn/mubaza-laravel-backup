<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    public $fillable = [
        'size', 'qty',
        'is_active', 'product_color_id'
    ];

    protected $hidden = [
        'qty'
    ];

    public function color()
    {
        return $this->belongsTo('App\ProductColor', 'product_color_id');
    }

}
