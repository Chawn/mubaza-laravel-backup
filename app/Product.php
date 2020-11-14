<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    public $fillable = [
        'name', 'price',
        'one_side_price', 'two_side_price',
        'max_price', 'category_id', 'primary'
    ];

    protected $dates = ['deleted_at'];

    public function getCover()
    {
        if($this->colors->count() <= 0) {
            return '';
        }

        return $this->colors->first();
    }

    public function getColorHas($id)
    {
        $product = Product::find($id);
        $data_colors = "";
        foreach ($product->image as $product_image) {
            if ($data_colors=="") {
               $data_colors = $product_image->color;
            }else{
               $data_colors = $data_colors.",".$product_image->color;
            }
        }

        return $data_colors ;

    }

    public function getImageHas($product_id)
    {
        $image = ProductColor::where('product_id', '=', $product_id)->get();
        $image_has = "";
        foreach ($image as $img) {
            if ($image_has=="") {
               $image_has = $img->id;
            }else{
               $image_has = $image_has.",".$img->id;
            }
        }

        return $image_has ;

    }

    public function getProductByArray($ids) {
        $products = $this->whereIn('id', $ids);
    }
    /*
     * New system function
     */
    public function getPrimaryColor()
    {
        return $this->colors()->where('primary', true)->first();
    }

    /*
     * End new system function
     */
    public function outline()
    {
        return $this->hasOne('App\ProductOutline', 'id');
    }

    public function colors()
    {
        return $this->hasMany('App\ProductColor', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function description()
    {
        return $this->hasOne('App\ProductDescription', 'id');
    }
}
