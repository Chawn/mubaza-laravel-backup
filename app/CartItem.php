<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public $timestamps = false;
    public $dates = ['affiliate_expired_at'];
    protected $fillable = [
        'campaign_id', 'campaign_product_id',
        'product_sku_id', 'qty',
        'affiliate_id', 'click_stat_id', 'affiliate_expired_at'
    ];

    public static function CreateItem($data)
    {
        $item = new CartItem();
        $item->campaign_id = $data['campaign_id'];
        $item->campaign_product_id = $data['campaign_product_id'];
        $item->product_sku_id = $data['product_sku_id'];
        $item->qty = $data['qty'];
        $affiliate = Affiliate::find(\Cookie::get('aff_id'));

        if($affiliate) {
            $item->affiliate()->associate($affiliate);
            $item->affiliate_id = \Cookie::get('aff_id');
            $item->affiliate_expired_at = \Carbon::createFromTimestamp(\Cookie::get('aff_last_update'))->addDay();
        }

        $click_stat = ClickStat::find(\Cookie::get('aff_cs_id'));

        if($click_stat) {
            $item->click_stat()->associate($click_stat);
        }

        return $item;
    }

    public function total()
    {
        return ($this->qty * $this->product->sell_price);
    }

    public static function RangeUpdate($items)
    {
        foreach($items as $item)
        {
            $cart_item = CartItem::find($item['id']);

            if(!$cart_item)
            {
                return false;
            }

            $cart_item->qty = $item['qty'];
            if(!$cart_item->save())
            {
                return false;
            }
        }

        return true;
    }

    public function affiliate()
    {
        return $this->belongsTo('App\Affiliate', 'affiliate_id');
    }
    public function click_stat() {
        return $this->belongsTo('App\ClickStat', 'click_stat_id');
    }

    public function cart()
    {
        return $this->belongsTo('App\Cart', 'cart_id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id');
    }

    public function product()
    {
        return $this->belongsTo('App\CampaignProduct', 'campaign_product_id');
    }

    public function sku()
    {
        return $this->belongsTo('App\ProductSku', 'product_sku_id');
    }
}
