<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    public $dates = [ 'deleted_at', 'produce_started_at' ];
    public $fillable = [
        'user_id', 'order_status_id', 'campaign_id',
        'shipping_type_id', 'shipping_status_id',
        'payment_type_id', 'payment_status_id',
        'sub_total', 'shipping_cost', 'order_produce_status_id',
        'before_discount_price_total',
        'net_price_total',
        'coupon_id',
        'coupon_discount_total',
    ];

    public static function GetAll ($keyword = '', $status = [ ])
    {
        $payments = Order::with('payment');

        if ( $keyword != '' ) {
            $payments->whereHas('user', function ($q) use ($keyword) {
                $q->where('full_name', 'like', '%' . $keyword . '%');
            });
        }

        if ( count($status) > 0 ) {
            $payments->whereIn('payment_status_id', $status);
        }
        return $payments;
    }

    public function getFullAddress ()
    {
        if ( $this->shipping_address ) {
            $address = $this->shipping_address;
            $full_address = '';
            $full_address .= $address->full_name;
            $full_address .= '<br>' . $address->address;
            if ( $address->building ) {
                $full_address .= '<br> อาคาร ' . $address->building;
            }
            $full_address .= '<br> อำเภอ ' . $address->district;
            $full_address .= '<br> จังหวัด ' . $address->province;
            $full_address .= '<br> ' . $address->zipcode;

            return $full_address;
        }
        return null;
    }

    /**
     * Get all ready to refund order
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allRefund ($limit = 0)
    {
        $orders = Order::with('campaign')->whereHas('campaign', function ($query) {
            $query->whereIn('campaign_status_id', [
                \App\CampaignStatus::whereName('ban')->first()->id,
                \App\CampaignStatus::whereName('cancel')->first()->id
            ]);
        })->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id);

        if ( $limit > 0 ) {
            return $orders->paginate($limit);
        }

        return $orders->get();
    }

    public static function allNotTransfer ()
    {
        $orders = Order::GetAll('', [ PaymentStatus::whereName('waiting')->first()->id ]);
        return $orders->get([ 'id' ]);
    }

    /**
     * Get all not approve
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allNotApprove ()
    {
        $orders = Order::GetAll('', [ PaymentStatus::whereName('transferred')->first()->id ]);
        return $orders->get([ 'id' ]);
    }

    public static function allPayment ()
    {
        $payments = Order::with('payment')
            ->whereIn('payment_status_id', [
                PaymentStatus::whereName('transferred')->first()->id,
                PaymentStatus::whereName('paid')->first()->id,
                PaymentStatus::whereName('cancel')->first()->id,
            ])
            ->orderBy('payment_status_id', 'asc')
            ->orderBy('updated_at', 'dsc')
            ->paginate(20);

        return $payments;
    }

    public static function allTransferred ($limit = 0)
    {
        $payments = Order::with('payment')
            ->whereIn('payment_status_id', [
                PaymentStatus::whereName('transferred')->first()->id,
                PaymentStatus::whereName('paid')->first()->id
            ])
            ->where('payment_type_id', \App\PaymentType::whereName('transfer')->first()->id)
            ->orderBy('payment_status_id', 'asc')
            ->orderBy('updated_at', 'dsc');
        if ( $limit > 0 ) {
            return $payments->paginate($limit);
        }
        return $payments->get();
    }

    public function totalQTY ()
    {
        $items = $this->items;

        $total = 0;

        foreach ( $items as $key => $item ) {
            $total += $item->qty;
        }

        return $total;

    }

    public static function countAll ($from = null, $to = null)
    {
        if ( $from != null && $to != null ) {
            return \DB::table('orders')->whereBetween('created_at', [ $from, $to ])
                ->select(\DB::raw('count(*) as order_count'))->first();
        }

        return \DB::table('orders')->select(\DB::raw('count(*) as order_count'))->first();
    }

    public static function countQTYAll ($from = null, $to = null)
    {
        if ( $from != null && $to != null ) {
            $data = \DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->whereBetween('orders.created_at', [ $from, $to ])
                ->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id)
                ->select(\DB::raw('sum(order_items.qty) as total_order'))->first();

            return $data;
        }

        $data = \DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id)
            ->select(\DB::raw('sum(order_items.qty) as total_order'))->first();

        return $data;
    }

    public function payoutStatus ()
    {
        if ( count($this->payout) > 0 ) {
            return $this->payout->status->detail;
        } else {
            return 'รอตรวจสอบการคืนเงิน';
        }
    }

    /*======================================================
     * New system function
     *======================================================*/

    // Producing function

    public function remainDay ()
    {
        if ( !$this->payment->confirmed_at ) {
            return null;
        }

        return 7 - ($this->payment->confirmed_at->diffInDays(\Carbon::now()));
    }

    public static function getWaiting ()
    {
        return self::whereHas('shipping_address', function () {
        })
            ->where('payment_status_id', PaymentStatus::paid()->id)
            ->where('order_status_id', OrderStatus::status(OrderStatus::WAIT_TO_PRODUCE)->id);
    }

    public static function getProducing ()
    {
        return self::whereHas('shipping_address', function () {
        })
            ->whereHas('shipping_address', function () {
            })
            ->where('payment_status_id', PaymentStatus::paid()->id)
            ->where('order_status_id', OrderStatus::status(OrderStatus::OPEN)->id);
    }

    public static function getShipping ()
    {
        return self::whereHas('shipping_address', function () {
        })
            ->whereHas('shipping_address', function () {
            })
            ->where('payment_status_id', PaymentStatus::paid()->id)
            ->where('order_status_id', OrderStatus::status(OrderStatus::SHIPPING)->id);
    }

    public static function getShipped ()
    {
        return self::whereHas('shipping_address', function () {
        })
            ->whereHas('shipping_address', function () {
            })
            ->where('payment_status_id', PaymentStatus::paid()->id)
            ->where('order_status_id', OrderStatus::status(OrderStatus::SHIPPED)->id);
    }


    /**
     * Set order status to cancel refund
     *
     * @return bool
     */
    public function setCancelRefund ()
    {
        $this->status()->associate(OrderStatus::cancel()->first());
        return $this->save();
    }

    /**
     * set produce status to producing
     *
     * @return bool
     */
    public function setProducing ()
    {
        $this->status()->associate(OrderStatus::status(OrderStatus::PRODUCING)->first());

        $this->produce_started_at = \Carbon::now();
        return $this->save();
    }

    /**
     * Set produce status to shipping
     *
     * @return bool
     */
    public function setProduced ()
    {
        $this->status()->associate(OrderStatus::status(OrderStatus::SHIPPING)->first());
        return $this->save();
    }

    /**
     * Set produce status to shipped
     *
     * @return bool
     */
    public function setShipped ()
    {
        $this->status()->associate(OrderStatus::status(OrderStatus::SHIPPED)->first());
        return $this->save();
    }

    /**
     * Total of money without shipping cost
     *
     * @return mixed
     */
    public function totalExcludeShippingCost ()
    {
        return $this->before_discount_price_total - $this->shipping_cost;
    }

    /**
     * Save tracking code to database
     *
     * @param $tracking_code
     * @return bool
     */
    public function updateTrackingCode ($tracking_code)
    {
        $this->shipping_address->tracking_code = $tracking_code;
        return $this->shipping_address->save();
    }

    /**
     * Total of money
     *
     * @return mixed
     */
    public function subTotal ()
    {
        return $this->sub_total;
    }

    /**
     * Shipping cost
     *
     * @return int
     */
    public function shippingCost ()
    {
        return Order::calShippingCost($this->shipping_type->name, $this->totalQTY());
    }

    public static function calShippingCost ($type = '', $qty = 0)
    {
        $cost = 0;

        if ( $qty == 0 ) {
            $cost = 0;
        } elseif ( $type == "registered" ) {
            $cost = 20;
        } elseif ( $type == "ems" ) {
            if ( $qty == 1 ) {
                $cost = 40;
            } elseif ( $qty >= 1 && $qty <= 6 ) {
                $cost = 50;
            } elseif ( $qty >= 7 && $qty <= 9 ) {
                $cost = 70;
            }
        } elseif ( $type == "kerry" ) {
            if ( $qty >= 1 && $qty <= 4 ) {
                $cost = 70;
            } elseif ( $qty >= 5 && $qty <= 25 ) {
                $cost = 90;
            } elseif ( $qty >= 26 && $qty <= 49 ) {
                $cost = 170;
            } elseif ( $qty >= 50 ) {
                $cost = 0;
            }
        }
        return $cost;
    }

    public function addItem (Cart $cart)
    {
        $result = 0;
        foreach ( $cart->items as $item ) {
            $order_item = new OrderItem();
            $order_item->qty = $item->qty;
            $order_item->price = $item->product->sell_price;
            $order_item->campaign_id = $item->campaign_id;
            $order_item->campaign_product_id = $item->campaign_product_id;
            $order_item->product_sku_id = $item->product_sku_id;
            $order_item->creator_rate = config('constant.creator_rate');
            $order_item->creator_commission = (($item->product->sell_price * config('constant.creator_rate')) / 100) * $item->qty;
            $order_item->commission_status()->associate(CommissionStatus::approving()->first());
            // Check has affiliate id for this item
            if ( $item->affiliate_expired_at > \Carbon::now() ) {
                $affiliate = Affiliate::where('id', $item->affiliate_id)->active()->first();
                if ( $affiliate && \Auth::user()->user()->id != $affiliate->user->id ) {
                    $affiliate_rate = $affiliate->getCurrentRate();
                    $order_item->affiliate_id = $item->affiliate_id;
                    $order_item->click_stat_id = $item->click_stat_id;
                    $order_item->affiliate_commission = (($item->product->sell_price * $affiliate_rate) / 100) * $item->qty;
                    $order_item->affiliate_rate = $affiliate_rate;
                }
            }

            $this->items()->save($order_item);

            $result++;
        }

        return $result;
    }

    public function createCardPayment (\OmiseCharge $charge)
    {
        $payment = new \App\Payment();
        $payment->total = $this->subTotal();
        $payment->pay_on = \Carbon::now();
        $payment->transaction_id = $charge[ 'id' ];
        $payment->from_bank = $charge[ 'card' ][ 'brand' ];
        $payment->remark = $charge[ 'reference' ];

        return $this->payment()->save($payment);
    }

    public function createTransferPayment ($data)
    {
        $payment = new \App\Payment();
        $payment->total = $data[ 'total' ];
        $payment->pay_on = \Carbon::createFromFormat('d/m/Y H:i', $data[ 'pay_on' ]);
        $payment->to_bank = $data[ 'to_bank' ];
        $payment->slip_upload = isset($data[ 'slip_upload' ]) ? $data[ 'slip_upload' ] : null;
        return $this->payment()->save($payment);
    }


    /**
     * Set order payment status to approve payment
     *
     * @return mixed
     */
    public function approve ()
    {
        $this->payment_status()->associate(PaymentStatus::approve());
        return $this->save();
    }

    public function is_paid ()
    {
        return $this->payment_status->id == PaymentStatus::paid()->id;
    }

    public function getCurrentStatusName ()
    {
        return $this->status->name;
    }

    /**
     * Set order payment status to paid
     *
     * @param bool $pay_by_transfer
     * @return mixed
     */
    public function setPaid ($pay_by_transfer = false)
    {
        $this->payment_status()->associate(PaymentStatus::paid());
        $this->status()->associate(OrderStatus::status(OrderStatus::WAIT_TO_PRODUCE)->first());

        if ( $this->payment_type->name == 'transfer' ) {
            $this->payment()->update([ 'confirmed_at' => \Carbon::now() ]);
        }

        $this->approveCommission();
        return $this->save();
    }

    public function cancel ($message = '')
    {
        $this->status()->associate(OrderStatus::status(OrderStatus::CANCEL)->first());
        $this->remark = $message;
        $this->cancelCommission();

        return $this->save();
    }

    public function reset ()
    {
        $this->payment_status()->associate(PaymentStatus::approve());
        $this->approvingCommission();
        $this->payment()->update([ 'confirmed_at' => null ]);

        return $this->save();
    }

    public static function getPaid ($id = '')
    {
        $orders = self::where('payment_status_id', PaymentStatus::paid()->id);

        if ( $id != '' ) {
            return $orders->whereId($id);
        }

        return $orders;
    }


    /**
     * Set all commission in order to be approved
     */
    public function approveCommission ()
    {
        $this->items()->update([
            'commission_status_id' => CommissionStatus::approved()->first()->id,
            'approved_at'          => \Carbon::now()
        ]);
    }

    /**
     * Set all commission in order to be approving
     */
    public function approvingCommission ()
    {
        $this->items()->hasAffiliate()->update([
            'commission_status_id' => CommissionStatus::approving()->first()->id,
            'approved_at'          => null
        ]);
    }

    /**
     * Set all commission in order to be cancel
     */
    public function cancelCommission ()
    {
        $this->items()->hasAffiliate()->update([
            'commission_status_id' => CommissionStatus::cancel()->first()->id,
            'approved_at'          => null
        ]);
    }

    public function createReturnItem ()
    {
        $items = $this->items;

        foreach ( $items as $index => $item ) {
            ReturnItem::firstOrCreate(['order_item_id' => $item->id]);
        }
    }

    /*
     * Scope section
     */


    /**
     * Scope query orders paid payment status
     *
     * @param $query
     * @return mixed
     */
    public function scopePaid ($query)
    {
        return $query->where('payment_status_id', PaymentStatus::paid()->id);
    }

    /**
     * Scope query orders producing status
     *
     * @param $query
     * @return mixed
     */
    public function scopeProducing ($query)
    {
        return $query->where('order_status_id', OrderStatus::status(OrderStatus::PRODUCING)->first()->id);
    }

    public function scopeWaitingProduce ($query)
    {
        return $query->where('order_status_id', OrderStatus::status(OrderStatus::WAIT_TO_PRODUCE)->first()->id);
    }

    public function scopeShipping ($query)
    {
        return $query->where('order_status_id', OrderStatus::status(OrderStatus::SHIPPING)->first()->id);
    }

    public function scopeShipped ($query)
    {
        return $query->where('order_status_id', OrderStatus::status(OrderStatus::SHIPPED)->first()->id);
    }

    public function scopeTransferPayment ($query)
    {
        return $query->where('payment_type_id', PaymentType::transfer()->id);
    }

    public function scopeOpen ($query)
    {
        return $query->where('order_status_id', OrderStatus::status(OrderStatus::OPEN)->first()->id);
    }

    public function scopeCanUpdatePayment ($query)
    {
        return $query->open()->whereIn('payment_status_id', [
            PaymentStatus::waiting()->id,
            PaymentStatus::approve()->id,
            PaymentStatus::cancel()->first()->id
        ]);
    }

    public function scopePaymentWaiting ($query)
    {
        return $query->where('payment_status_id', PaymentStatus::waiting()->id);
    }

    public function scopePaymentApprove ($query)
    {
        return $query->where('payment_status_id', PaymentStatus::approve()->id);
    }
    /*
     * End Scope
     */
    /*
     * End counpon system function
     */
    /*======================================================
     * End new system function
     *======================================================*/

    public function return_order ()
    {
        return $this->hasOne(ReturnOrder::class);
    }
    public function trackings ()
    {
        return $this->hasMany(OrderTracking::class);
    }

    public function items ()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function status ()
    {
        return $this->belongsTo('App\OrderStatus', 'order_status_id');
    }

    public function produce_status ()
    {
        return $this->belongsTo('App\OrderProduceStatus', 'order_produce_status_id');
    }

    public function shipping_type ()
    {
        return $this->belongsTo('\App\ShippingType', 'shipping_type_id');
    }

    public function shipping_address ()
    {
        return $this->hasOne('App\ShippingAddress', 'id');
    }

    public function payment_type ()
    {
        return $this->belongsTo('App\PaymentType', 'payment_type_id');
    }

    public function payment_status ()
    {
        return $this->belongsTo('App\PaymentStatus', 'payment_status_id');
    }

    public function payment ()
    {
        return $this->hasOne('App\Payment');
    }

    public function payments ()
    {
        return $this->hasMany(Payment::class);
    }

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function card ()
    {
        return $this->hasMany('App\Card');
    }

    public function payout ()
    {
        return $this->hasMany('\App\Payout');
    }
}
