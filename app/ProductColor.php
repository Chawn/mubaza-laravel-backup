<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{

    public $timestamps = FALSE;
    public $fillable = [
        'color', 'color_name', 'image_front', 'image_back',
        'is_cover', 'available_size', 'product_id'
    ];

    public function scopeProduct_Id($query,$id)
    {
        return $query->where('product_id', '=', $id);
    }

    public function getImageFront()
    {
        return \Storage::get($this->image_front);
    }
//    public function getAvailableSize($has_size)
//    {
//        $sizes = explode(',', $this->available_size);
//        foreach ($sizes as $size) {
//            if ($has_size === $size) {
//                return TRUE;
//            }
//        }
//
//        return FALSE;
//    }

    /*
     * New system function
     */
    public static function getAvailableColor ()
    {
        return self::active()->groupBy('color')->get(['id', 'color', 'color_name']);
    }

    public function scopeActive ($query)
    {
        return $query->where('active', true);
    }
    /**
     * Get available size for product as collection
     * @return mixed
     * @internal param $product_id
     */
    public function getAvailableSize()
    {
        $sizes = $this->sku()->where('is_active', true)->get(['size']);

        return array_flatten($sizes->toArray());
    }

    /**
     * Get available size for product as string
     * @return string
     * @internal param $product_id
     */
    public function getAvailableSizeString()
    {
        $sizes = $this->getAvailableSize();
        $size_has = '';

        foreach ($sizes as $key => $size) {
            if ($size_has === '') {
                $size_has = $size;
            } else {
                $size_has .= ',' . $size;
            }
        }

        return $size_has;
    }

    public function isAvailableSize($size)
    {
        $sizes = $this->getAvailableSize();

        foreach ($sizes as $key => $value) {
            if($value == $size) {
                return true;
            }
        }

        return false;
    }

    public static function scopeAllColor($query)
    {
        return $query->groupBy('color');
    }

    public function getPrimaryAttribute($value)
    {
        return $value ? true : false;
    }
    /*
     * End new system function
     */
    public function getColorWithoutSharp() {
        return substr($this->color, 1, strlen($this->color));
    }
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
    public function sku()
    {
        return $this->hasMany('App\ProductSku');
    }

    public function campaign_products()
    {
        return $this->hasMany('App\CampaignProduct');
    }
}
