<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignProduct extends Model {

	public $timestamps = false;

    public $fillable = [
        'campaign_id', 'product_color_id',
        'sell_price', 'min_price',
        'image_front', 'image_front_thmb',
        'image_front_small', 'image_front_medium',
        'image_front_large',
        'deleted', 'is_primary'
    ];

    public function getOrderedItem() {
        $campaign = \App\CampaignProduct::with('order_items', 'order_items.orders')->where('id', $this->id)->first();
        $total = 0;
        foreach($campaign->order_items as $v)
        {
            if($v->orders->payment_status->name == 'paid' || $v->orders->payment_status->name == 'paid_by_card')
            {
                $total += $v->qty;
            }
        }

        return $total;
    }

    public static function sumPrice($id, $qty)
    {
        $campaign_product = CampaignProduct::find($id);

        return ($campaign_product->sell_price * $qty);
    }

    /*
     * New system function
     */

    /**
     * Set to primary product
     * @return bool
     */
    public function setPrimary()
    {
        CampaignProduct::where('campaign_id', $this->campaign_id)->where('is_primary', true)->update(['is_primary' => false]);

        $this->is_primary = true;

        if($this->save())
        {
            return true;
        }

        return false;
    }

    public function getCover()
    {
        if($this->campaign->both_print) {
            return $this->image_front_medium;
        }
        return $this->image_front_medium ;
    }


    public static function scopeSurprise($query, $category_id = '', $product_id = '', $color = '')
    {
        $campaigns = CampaignProduct::where('is_deleted', false);

        if($color != ''){
            $campaigns = $campaigns->whereHas('color', function($query) use($color, $product_id) {
                $query->where('color_name', $color);
            });
        }

        if($product_id != '') {
            $campaigns = $campaigns->whereHas('color', function ($query) use ($product_id) {
                $query->whereHas('product', function ($q) use ($product_id) {
                    $q->where('id', $product_id);
                });
            });
        }

        if($category_id != '') {
            $campaigns = $campaigns->whereHas('campaign', function ($query) use ($category_id) {
                $query->where('campaign_category_id', $category_id);
            });
        }


//        dd($campaigns->first());
        if(!$campaigns) {
            return null;
        }

        return $campaigns->first()->campaign;
    }

    public function scopePrimary ($query)
    {
        return $query->where('is_primary', true);
    }
    /*
     * End new system function
     */
    public function campaign() {
        return $this->belongsTo('App\Campaign', 'campaign_id');
    }
    public function color() {
        return $this->belongsTo('App\ProductColor', 'product_color_id');
    }
    public function order_items() {
        return $this->hasMany('App\OrderItem');
    }
}
