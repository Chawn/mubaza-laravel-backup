<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'session_id', 'campaign_id'
    ];

    /**
     * Get total order in cart
     * @return int
     */
    public function total()
    {
        $total = 0;

        foreach($this->items as $item) {
            $total += ($item->qty * $item->product->sell_price);
        }

        return $total;
    }

    public function availableShippingType()
    {
        $qty = $this->totalQty();
        $shipping_types = config('shipping-cost');
        $data= [];
        foreach($shipping_types as $key => $shipping_type) {
            foreach ($shipping_type as $cost) {
                if($qty >= $cost['min'] && $qty <= $cost['max'])
                {
                    if(isset($data[$key])) {
                        array_push($data[$key], $cost);
                    } else {
                        $data[$key] = $cost;
                    }
                }
            }
        }

        return $data;
    }
    /**
     * Get total order qty in cart
     * @return int
     */
    public function totalQty()
    {
        $total_qty = 0;

        foreach($this->items as $item) {
            $total_qty += ($item->qty);
        }

        return $total_qty;
    }

    /**
     * Add item cart
     * @param $item
     */
    public function addItem($item)
    {
        $cart_item = CartItem::where('cart_id', $this->id)
            ->where('campaign_id', $item['campaign_id'])
            ->where('campaign_product_id', $item['campaign_product_id'])
            ->where('product_sku_id', $item['product_sku_id'])
            ->first();

        if ($cart_item) {
            $cart_item->qty += intval($item['qty']);
        } else {
            $cart_item = CartItem::CreateItem($item);
        }
        $this->items()->save($cart_item);
    }

    public function items()
    {
        return $this->hasMany('App\CartItem');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id');
    }
}
