<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Date\Date;

class Campaign extends Model
{

    use SoftDeletes;

    public $dates = [ 'deleted_at', 'start', 'end' ];

    public $fillable = [
        'title', 'description', 'url',
        'image_front', 'image_back', 'back_cover',
        'end', 'end_amount', 'campaign_type_id',
        'campaign_status_id', 'user_id', 'remark',
        'back_cover', 'is_recommended', 'is_user_deleted',
        'campaign_category_id', 'both_print'
    ];

//    public static function search($keyword = '', $sort = '', $order = 'asc', $limit = 0, $current_page)
//    {
//        $tag = null;
//        if ($keyword != '') {
//            $tag = Tag::whereName($keyword)->first();
//        }
//        if ($keyword == 'ทั้งหมด') {
//            $keyword = '';
//        }
//
//        if ($sort == 'latest') {
//            $sort = 'id';
//            $order = 'desc';
//        }
//
//        $campaigns = null;
//        $campaigns = \DB::table('campaigns')->leftJoin('campaign_products', 'campaign_products.campaign_id', '=', 'campaigns.id')
//            ->leftJoin('campaign_tag', 'campaign_tag.campaign_id', '=', 'campaigns.id')
//            ->leftJoin('campaign_designs', 'campaign_designs.id', '=', 'campaigns.campaign_design_id')
//            ->where('campaign_type_id', CampaignType::whereName('sell')->first()->id)
//            ->whereIn('campaign_status_id', [
//                CampaignStatus::whereName('running')->first()->id,
//                CampaignStatus::whereName('close')->first()->id,
//                CampaignStatus::whereName('cancel')->first()->id
//            ])
//            ->whereNull('campaigns.deleted_at');
//
//        if ($tag) {
//            $campaigns->where(function ($q) use ($tag, $keyword) {
//                $q->where('title', 'like', '%' . $keyword . '%');
//                $q->orWhere('campaign_tag.tag_id', $tag->id);
//            });
//        } else {
//
//            $campaigns->where('title', 'like', '%' . $keyword . '%');
//        }
//
//        if ($sort != '') {
//            if ($sort == 'price') {
//                if ($order == "low") {
//                    $order = 'asc';
//                } elseif ($order == 'high') {
//                    $order = 'desc';
//                }
//                $campaigns = $campaigns->orderBy('sell_price', $order);
//            } else {
//                $campaigns = $campaigns->orderBy($sort, $order);
//            }
//        } else {
//            $campaigns = $campaigns->orderBy('campaigns.id', 'desc');
//        }
//
//        if ($limit <= 0) {
//            $limit = 12;
//        }
//
//        if ($current_page == 1) {
//            $campaigns = $campaigns->take($limit);
//        } else {
//            $campaigns = $campaigns->skip(($limit * ($current_page - 1)) - 1)->take($limit);
//        }
//        return [ 'result' => $campaigns->groupBy('campaigns.id') ];
//    }

    public static function GetCampaign ($status_id = [ ], $produce_status = [ ], $ended = false, $type = '', $sort = 'id', $order = 'asc')
    {
        $campaigns = Campaign::whereNull('deleted_at');

        if ( $ended ) {
            $campaigns->where('end', '<', \Carbon::now());
        }

        if ( count($status_id) > 0 ) {
            $campaigns->whereIn('campaign_status_id', $status_id);
        }

        if ( count($produce_status) > 0 ) {
            $campaigns->whereIn('campaign_produce_status_id', $produce_status);
        }

        if ( $type != '' ) {
            $campaigns->where('campaign_type_id', CampaignType::whereName($type)->first()->id);
        }


        $campaigns->orderBy($sort, $order);

        return $campaigns;
    }

    public function BlockCount ()
    {
        if ( $this->design == null ) {
            return 0;
        }

        return $this->design->block_front_count + $this->design->block_back_count;
    }

    public function ScreenCost ($qty = 0)
    {
        if ( $qty == 0 ) {
            $qty = $this->goal;
        }

        return (config('constant.printing_unit_cost') * $this->BlockCount()) * $qty;
    }

    function minPrice ($block_cost, $product_cost, $screen_cost, $qty)
    {
        return round(($block_cost + $product_cost + $screen_cost) / $qty);
    }

    public function getLessProfit ()
    {
        $products = $this->products;
        $block_cost = $this->block_cost;
        $screen_cost = $this->ScreenCost();
        $goal = $this->goal;
        $profits = [ ];
        foreach ( $products as $product ) {
            $total_product_cost = $product->product->price * $goal;
            $min_price = $this->minPrice($block_cost, $total_product_cost, $screen_cost, $goal);
            $profit = $product->sell_price - $min_price;
            array_push($profits, [
                'id' => $product->id,
                'sell_price' => intVal($product->sell_price),
                'unit_price' => intVal($product->product->price),
                'profit' => $profit
            ]);
        }

        $profits = array_values(array_sort($profits, function ($value) {
            return $value[ 'profit' ];
        }));

        return $profits[ count($profits) - 1 ];
    }

    public function getMinProduce ()
    {
        $this->getLessProfit();
        $total_profit = $this->totalProfit();

        if ( $total_profit >= config('constant.profit_to_produce') ) {
            return '<p class="text-center alert alert-info"><b>ยินดีด้วย! แคมเปญนี้ได้รับการผลิตแล้ว</b><br>คุณยังสามารถสั่งซื้อได้จนกว่าแคมเปญจะหมดเวลา</p>';
        }

        if ( $this->totalOrder() <= 0 ) {
            return false;
        }

        $goal = $this->totalOrder();
        $product = $this->getLessProfit();
        $sell = $product[ 'sell_price' ];
        $unit_price = $product[ 'unit_price' ];
        $block_cost = intVal($this->block_cost);
        $all_profit = 0;
        $product[ 'block_cost' ] = $block_cost;
        $product[ 'block_count' ] = $this->BlockCount();
        while ( $all_profit < config('constant.profit_to_produce') ) {
            $screen_cost = $this->ScreenCost($goal);
            $total_product_cost = $unit_price * $goal;
            $min_price = round(($block_cost + $total_product_cost + $screen_cost) / $goal);
            $product[ 'min_price' ] = $min_price;
            $product[ 'screen_cost' ] = $screen_cost;
            $product[ 'all_profit' ] = $all_profit;


            if ( $min_price < $sell ) {
                $all_profit = ($sell - $min_price) * $goal;
            }
            $goal++;
        }
        $product[ 'qty' ] = $goal;
        $product[ 'total_order' ] = $this->totalOrder();
        $remain = ($goal - $this->totalOrder()) - 1;
        $product[ 'remain' ] = $remain;

        if ( $remain > 0 ) {
            return '<p class="text-center alert alert-info"><b>ยินดีด้วย! แคมเปญนี้ได้รับการผลิตแล้ว</b><br>คุณยังสามารถสั่งซื้อได้จนกว่าแคมเปญจะหมดเวลา</p>';
        }
        if ( $remain <= 10 ) {
            return '<p class="text-center alert alert-info">อีก ' . $remain . ' ตัว แคมเปญนี้ก็จะได้รับการผลิตแล้ว!</p>';
        }
        return false;
    }

    public function paidOrder ()
    {
        $orders = \App\Order::where('campaign_id', $this->id)
            ->where('payment_status_id', \App\PaymentStatus::whereName('paid')->first()->id);

        return $orders;
    }

    public function getImageFrontPreviewAttribute ($attr)
    {
        return url('/') . '/' . $attr;
    }

    public function getImageBackPreviewAttribute ($attr)
    {
        return url('/') . '/' . $attr;
    }

    public function getEndDate ($locale = 'th')
    {
        Date::setLocale($locale);
        return new Date($this->end->format('d F Y H:i'));
    }

    public function isProduce ()
    {
        $campaign_statuses = CampaignStatus::whereIn('name', [ 'กำลังดำเนินการผลิต', 'ผลิตเรียบร้อยแล้ว' ])->get();
        foreach ( $campaign_statuses as $campaign_status ) {
            if ( $campaign_status->id === $this->campaign_status_id ) {
                return true;
            }
        }

        return false;
    }

    public function getRemainTime ()
    {
        $end = $this->end;
        Date::setLocale('th');
        $date = Date::create($end->year, $end->month, $end->day, $end->hour, $end->minute, $end->second);
        $diff_string = '';

        if ( $end > Date::now() ) {
            $diff_dates = $date->diffInDays();
            $diff_hours = $date->diffInHours();
            $diff_minutes = $date->diffInMinutes();

            if ( $diff_dates > 0 ) {
                $diff_string .= 'เหลือ ' . $diff_dates . ' วัน ';
            } elseif ( $diff_hours > 0 ) {
                $diff_string .= 'เหลือ ' . $diff_hours . ' ชั่วโมง ';
            } elseif ( $diff_minutes > 0 ) {
                $diff_string .= 'เหลือ ' . $diff_minutes . ' นาที ';
            }
        } else {
            $diff_string .= 'หมดเวลาแล้ว';
        }

        return $diff_string;
    }

    public function getRemainTimeNumber ()
    {
        $end = $this->end;
        Date::setLocale('th');
        $date = Date::create($end->year, $end->month, $end->day, $end->hour, $end->minute, $end->second);
        $diff_string = '';

        if ( $end > Date::now() ) {
            $diff_dates = $date->diffInDays();
            $diff_hours = $date->diffInHours();
            $diff_minutes = $date->diffInMinutes();

            if ( $diff_dates > 0 ) {
                $diff_string .= $diff_dates . ' วัน ';
            } elseif ( $diff_hours > 0 ) {
                $diff_string .= $diff_hours . ' ชั่วโมง ';
            } elseif ( $diff_minutes > 0 ) {
                $diff_string .= $diff_minutes . ' นาที ';
            }
        } else {
            $diff_string .= 'หมดเวลาแล้ว';
        }

        return $diff_string;
    }

    public function getShortRemainTime ()
    {
        $end = $this->end;
        Date::setLocale('th');
        $date = Date::create($end->year, $end->month, $end->day, $end->hour, $end->minute, $end->second);
        $diff_string = '';

        if ( $end > Date::now() ) {
            $diff_dates = $date->diffInDays();
            $diff_hours = $date->diffInHours();
            $diff_minutes = $date->diffInMinutes();

            if ( $diff_dates > 0 ) {
                $diff_string = $diff_dates . ' วัน';
            } elseif ( $diff_hours > 0 ) {
                $diff_string = $diff_hours . ' ชั่วโมง';
            } elseif ( $diff_minutes > 0 ) {
                $diff_string = $diff_minutes . ' นาที';
            }
        } else {
            $diff_string .= 'หมดเวลาแล้ว';
        }

        return $diff_string;
    }


    public function isSell ()
    {
        return ($this->campaign_type_id === CampaignType::whereName('sell')->first()->id);
    }

    public function isRunning ()
    {
        return ($this->end->get(\Carbon::now()));
    }


    public function getAllOrderedItem ()
    {
        $data = NULL;
        $orders = $this->orders;
        foreach ( $orders as $k => $order ) {
            $order_items = OrderItem::select('*', DB::raw('sum(qty) as total'))
                ->where('order_id', '=', $order->id)->groupBy('size')->get();

            foreach ( $order_items as $key => $order_item ) {
                if ( isset($data[ $order_item->product_id ][ 'size' ][ $order_item->size ]) ) {
                    $data[ $order_item->product_id ][ 'size' ][ $order_item->size ] += $order_item->total;
                } else {
                    $data[ $order_item->product_id ][ 'data' ] = Product::find($order_item->product_id);
                    $data[ $order_item->product_id ][ 'size' ][ $order_item->size ] = $order_item->total;
                }
            }
        }

        return $data;
    }

    public function getSellPrice ()
    {
        $block_cost = $this->block_cost;
        $screen_cost = $this->screen_cost;
        $product_price_total = 0;
        $product_qty_total = 0;
        foreach ( $this->orders as $order ) {
            foreach ( $order->allItems as $key => $item ) {
                $product_qty_total += $item->qty;
                $product_price_total += $item->qty * $item->item->sell_price;
            }
        }

        return [ $product_qty_total, $product_price_total ];
    }

    public function getCoverMini ()
    {
        $src = "image_url_cover";
        $campaign = Campaign::find($this->id);
        if ( $campaign->back_cover ) {
            $src = $campaign->design->image_back_preview_thmb;
        } else {
            $src = $campaign->design->image_front_preview_thmb;
        }
        return $src;
    }

    public function getSold ()
    {
        $sold = $this->totalOrder();
        if ( $sold < 1 ) {
            return "สั่งซื้อเลย";
        } else {
            return "ขายแล้ว " . $sold;
        }
    }

    public function getSoldNumber ()
    {
        $sold = $this->totalOrder();
        return $sold;
    }

    public function totalOrder ()
    {
        $orders = Order::with('allItems')->where('campaign_id', $this->id)->get();
        $total = 0;

        foreach ( $orders as $index => $order ) {
            if ( $this->is_checked ) {
                if ( $order->payment_status->name == 'paid' ) {
                    foreach ( $order->allItems as $key => $item ) {
                        $total += $item->qty;
                    }
                }
            } else {
                if ( $order->payment_status->name == 'paid' ||
                    ($order->payment_status->name == 'paid_by_card')
                )
                    foreach ( $order->allItems as $key => $item ) {
                        $total += $item->qty;
                    }
            }
        }
        return $total;
    }

    public function totalPayment ()
    {
        $orders = Order::where('campaign_id', $this->id)
            ->where('payment_status_id', '<>', PaymentStatus::whereName('cancel')->first()->id)
            ->with('allItems', 'allItems.item')->get();
        $total = 0;

        foreach ( $orders as $key => $order ) {
            foreach ( $order->allItems as $id => $item ) {
                $total += $item->item->sell_price * $item->qty;
            }
        }
        return $total;
    }

    /**
     * Get total of profit for campaign
     *
     * @return int
     */
    public function totalProfit ()
    {
        if ( $this->is_checked ) {
            $orders = Order::where('campaign_id', $this->id)
                ->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id)
                ->with('allItems', 'allItems.item')->get();
        } else {
            $orders = Order::where('campaign_id', $this->id)
                ->where(function ($q) {
                    $q->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id);
                    $q->orWhere('payment_status_id', PaymentStatus::whereName('paid_by_card')->first()->id);
                })
                ->with('allItems', 'allItems.item')->get();
        }
        $profits = [ ];

        if ( $this->totalOrder() <= 0 ) {
            return 0;
        }

        $block_cost = $this->block_cost;
        $screen_cost = $this->ScreenCost($this->totalOrder());

        $profit = 0;

        foreach ( $orders as $index => $order ) {
            foreach ( $order->allItems as $key => $item ) {
                $total_product_cost = $item->item->product->price * $this->totalOrder();

                $min_price = ($block_cost + $total_product_cost + $screen_cost) / $this->totalOrder();

                $profit += ($item->item->sell_price - $min_price) * $item->qty;
            }
        }

        if ( $profit < 0 ) {
            return 0;
        }

        return $profit;
    }

    public function closeOrder ()
    {
        $orders = Order::where('campaign_id', $this->id)
            ->whereIn('payment_status_id', [
                PaymentStatus::whereName('waiting')->first()->id,
                PaymentStatus::whereName('transferred')->first()->id
            ])->get();

        foreach ( $orders as $key => $order ) {
            $order->payment_status()->associate(PaymentStatus::whereName('cancel')->first());
            if ( !$order->save() ) {
                return false;
            }
        }

        return true;

    }

    /**
     * Get all bank transfer total
     *
     * @return int
     */
    public function totalTransfer ()
    {
        $orders = Order::where('campaign_id', $this->id)
            ->where('payment_type_id', \App\PaymentType::whereName('transfer')->first()->id)
            ->where('payment_status_id', '<>', PaymentStatus::whereName('cancel')->first()->id)
            ->with('allItems', 'allItems.item')->get();

        $total = 0;
        foreach ( $orders as $key => $order ) {
            if ( $order->shipping_type_id == \App\ShippingType::whereName('ems')->first()->id ) {
                $total += config('constant.transport_cost');
            }

            foreach ( $order->allItems as $id => $item ) {
                $total += $item->item->sell_price * $item->qty;
            }

        }

        return $total;
    }

    /**
     * Get all card total
     *
     * @return int
     */
    public function totalCard ()
    {
        $orders = Order::where('campaign_id', $this->id)
            ->where('payment_type_id', \App\PaymentType::whereName('card')->first()->id)
            ->where('payment_status_id', '<>', PaymentStatus::whereName('cancel')->first()->id)
            ->with('allItems', 'allItems.item')->get();

        $total = 0;
        foreach ( $orders as $key => $order ) {
            if ( $order->shipping_type_id == \App\ShippingType::whereName('ems')->first()->id ) {
                $total += config('constant.transport_cost');
            }
            foreach ( $order->allItems as $id => $item ) {
                $total += $item->item->sell_price * $item->qty;
            }
        }
        return $total;
    }

    /**
     * Get all bank transferred total
     *
     * @return int
     */
    public function totalTransferred ()
    {
        $orders = Order::where('campaign_id', $this->id)
            ->where('payment_type_id', \App\PaymentType::whereName('transfer')->first()->id)
            ->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id)
            ->with('allItems', 'allItems.item')->get();

        $total = 0;
        foreach ( $orders as $key => $order ) {
            $total += $order->payment->first()->total;
        }

        return $total;
    }

    /**
     * Get all card charged total
     *
     * @return int
     */
    public function totalCardCharged ()
    {
        $orders = Order::where('campaign_id', $this->id)
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->where('payment_type_id', \App\PaymentType::whereName('card')->first()->id)
            ->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id)
            ->where('payments.is_charged', '1')->get();

        $total = 0;
        foreach ( $orders as $key => $order ) {
            $total += $order->total;
        }

        return $total;
    }

    /**
     * Calculate minimum price for campaign product
     *
     * @param $unit_price
     * @param $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function getMinimumPrice ($unit_price, $goal)
    {
        if ( !session('block_cost') ) {
            return [ 'success' => false, 'message' => 'ไม่มีค่าของราคาบล็อกในระบบ', 'value' => 0 ];
        }

        if ( !session('block_count') ) {
            return [ 'success' => false, 'message' => 'ไม่มีค่าของจำนวนบล็อกในระบบ', 'value' => 0 ];
        }

        $block_cost = session('block_cost');
        $block_count = session('block_count');
        $screen_cost = (config('constant.printing_unit_cost') * $block_count) * $goal;
        $total_product_cost = $unit_price * $goal;

        $min_price = round(($block_cost + $total_product_cost + $screen_cost) / $goal);

        return [ 'success' => true, 'message' => 'Success', 'value' => $min_price ];
    }

    public function orderPercentage ()
    {
        $total_order = $this->totalOrder();
        if ( $total_order <= 0 ) {
            return 0;
        }

        $percent = round(($total_order * 100) / $this->goal);
        $percent = 20;
        if ( $percent > 100 ) {
            return 100;
        }
        return $percent;
    }

    public static function TopSell ()
    {
        $campaigns = Campaign::with('orders')
            ->where('campaign_status_id', CampaignStatus::whereName('running')->first()->id)
            ->where('campaign_type_id', CampaignType::whereName('sell')->first()->id)
            ->where('end', '>=', \Carbon::now())
            ->whereHas('orders', function ($q) {
                $q->where('payment_status_id', '<>', PaymentStatus::whereName('waiting')->first()->id);
            })->get();

        $campaign_id = '';
        foreach ( $campaigns as $key => $campaign ) {
            if ( $key == 0 ) {
                $campaign_id .= $campaign->id;
            } else {
                $campaign_id .= ', ' . $campaign->id;
            }
        }

        $top_sells = [ ];
        if ( $campaign_id != '' ) {
            $data = \DB::select(\DB::raw('SELECT campaigns.id, (SELECT SUM(order_items.qty) '
                . 'FROM order_items INNER JOIN orders ON orders.id = order_items.order_id '
                . 'WHERE orders.campaign_id = campaigns.id AND (orders.payment_status_id = '
                . PaymentStatus::whereName('paid')->first()->id
                . ' OR (orders.payment_status_id = ' . PaymentStatus::whereName('paid_by_card')->first()->id
                . ' )))  as total_qty, campaigns.end ' . 'FROM campaigns WHERE campaigns.id IN (' . $campaign_id . ') ' . 'ORDER BY total_qty DESC, end ASC;'));
            $i = 1;
            foreach ( $data as $key => $item ) {
                if ( $i > 6 ) {
                    break;
                }
                $campaign = Campaign::find($item->id);
                if ( $campaign->totalOrder() > 0 ) {
                    array_push($top_sells, $campaign);
                }
                $i++;
            }
        }

        return $top_sells;
    }

    public static function Recommended ()
    {
        $campaigns = Campaign::where('end', '>=', \Carbon::now())
            ->where('campaign_type_id', CampaignType::whereName('sell')->first()->id)
            ->where('campaign_status_id', CampaignStatus::whereName('running')->first()->id)
            ->where('is_recommended', true)
            ->orderBy('end')
            ->paginate(6);
        $campaign_id = '';
        foreach ( $campaigns as $key => $campaign ) {
            if ( $key == 0 ) {
                $campaign_id .= $campaign->id;
            } else {
                $campaign_id .= ', ' . $campaign->id;
            }
        }

        $recommends = [ ];
        if ( $campaign_id != '' ) {
            $data = \DB::select(\DB::raw('SELECT campaigns.id, (SELECT SUM(order_items.qty) '
                . 'FROM order_items INNER JOIN orders ON orders.id = order_items.order_id '
                . 'WHERE orders.campaign_id = campaigns.id)  as total_qty, campaigns.end '
                . 'FROM campaigns WHERE campaigns.id IN (' . $campaign_id . ') ORDER BY total_qty DESC, end ASC;'));

            $i = 1;
            foreach ( $data as $key => $item ) {
                if ( $i > 6 ) {
                    break;
                }
                $campaign = Campaign::find($item->id);
                array_push($recommends, $campaign);
                $i++;
            }
        }
        return $recommends;
    }

    /**
     * Get all campaign in produced status
     *
     * @param int $limit
     * @return mixed
     */

    public static function allProduced ($limit = 0)
    {
        $campaigns = Campaign::GetCampaign([ CampaignStatus::whereName('close')->first()->id ],
            [ CampaignProduceStatus::whereName('shipping')->first()->id ], true, 'sell', 'end', 'desc');

        if ( $limit > 0 ) {
            return $campaigns->paginate($limit);
        }

        return $campaigns->get();
    }

    /**
     * Get running campaign is ready to producing
     *
     * @param int $limit
     * @return mixed
     */
    public static function allReadyProduce ($limit = 0)
    {
        $campaigns = Campaign::orderBy('end', 'desc')
            ->where('campaign_produce_status_id', CampaignProduceStatus::whereName('waiting')->first()->id)
            ->where(function ($query) {
                $query->where('campaign_status_id', CampaignStatus::whereName('close')->first()->id)
                    ->orWhere('end', '<', \Carbon::now());
            });

        if ( $limit > 0 ) {
            return $campaigns->paginate($limit);
        }
        return $campaigns->get();
    }

    /**
     * Get all campaign in producing status
     *
     * @param int $limit
     * @return mixed
     */
    public static function allProducing ($limit = 0)
    {
        $campaigns = Campaign::GetCampaign([ CampaignStatus::whereName('close')->first()->id ],
            [ CampaignProduceStatus::whereName('producing')->first()->id ], true, 'sell', 'end', 'desc');

        if ( $limit > 0 ) {
            return $campaigns->paginate($limit);
        }
        return $campaigns->get();
    }

    /**
     * Get all campaign has profit to pay for designer
     *
     * @param int $limit
     * @return mixed
     */
    public static function allProfitable ($limit = 0)
    {
        $campaigns = Campaign::with('orders')->whereNotIn('campaign_status_id', [
            CampaignStatus::whereName('running')->first()->id,
            CampaignStatus::whereName('ban')->first()->id,
            CampaignStatus::whereName('cancel')->first()->id
        ])->whereNotIn('campaign_produce_status_id', [
            CampaignProduceStatus::whereName('approve')->first()->id,
            CampaignProduceStatus::whereName('cancel')->first()->id
        ]);

        if ( $limit > 0 ) {
            return $campaigns->paginate($limit);
        }

        return $campaigns->get();
    }

    /**
     * Get all campaign ready to approve
     *
     * @param int $limit
     * @return mixed
     */
    public static function allApprove ($limit = 0)
    {
        $campaigns = Campaign::where('end', '<', \Carbon::now())
            ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)
            ->whereIn('campaign_status_id', [
                CampaignStatus::whereName('running')->first()->id,
                CampaignStatus::whereName('close')->first()->id
            ])
            ->where('campaign_produce_status_id', CampaignProduceStatus::whereName('approve')->first()->id)
            ->orderBy('end', 'asc');
        if ( $limit > 0 ) {
            return $campaigns->paginate($limit);
        }

        return $campaigns->get();
    }

    public static function checkUrl ($url, $old_url = '')
    {
        $campaign = Campaign::where('url', $url);

        if ( $old_url != '' ) {
            $campaign = $campaign->where('url', '<>', $old_url);
        }

        if ( count($campaign->get([ 'url' ])) ) {
            return false;
        }
        return true;
    }

    public function deleteOrder ()
    {
        $orders = $this->orders;

        foreach ( $orders as $key => $order ) {
            $order->delete();
        }
    }

    public function campaignStatus ()
    {
        if ( $this->isRunning() ) {
            $campaignStatus = CampaignStatus::find($this->campaign_status_id);
            return $campaignStatus->detail;
        }
        return "แคมเปญสิ้นสุดแล้ว";
    }

    public static function countAll ($from = null, $to = null)
    {
        if ( $from != null && $to != null ) {
            return \DB::table('campaigns')->whereBetween('created_at', [ $from, $to ])
                ->select(\DB::raw('count(*) as campaign_count'))->first();
        }

        return \DB::table('campaigns')->select(\DB::raw('count(*) as campaign_count'))->first();
    }

    public static function CampaignNotifyData ()
    {
        $count = [ ];

        $count[ 'ready' ] = Campaign::orderBy('end', 'desc')
            ->where('campaign_produce_status_id', CampaignProduceStatus::whereName('waiting')->first()->id)
            ->where(function ($query) {
                $query->where('campaign_status_id', CampaignStatus::whereName('close')->first()->id)
                    ->orWhere('end', '<', \Carbon::now());
            })->select(\DB::raw('count(id) as count'))->first()->count;

        $count[ 'producing' ] = Campaign::GetCampaign([ CampaignStatus::whereName('close')->first()->id ],
            [ CampaignProduceStatus::whereName('producing')->first()->id ], true, 'sell')
            ->select(\DB::raw('count(id) as count'))->first()->count;

        $count[ 'produced' ] = Campaign::GetCampaign([ CampaignStatus::whereName('close')->first()->id ],
            [ CampaignProduceStatus::whereName('shipping')->first()->id ], true, 'sell')
            ->select(\DB::raw('count(id) as count'))->first()->count;

        return $count;

    }

    /*===================================================================================
     * New system function
     *===================================================================================*/
    public function profit ($start = '', $end = '')
    {
        $items = $this->order_items()->whereHas('order', function ($q) {
            $q->where('payment_status_id', PaymentStatus::paid()->id);
        })->get();
        return $items;
    }

    public function updateSellPrice ($prices)
    {
        if ( count($prices) <= 0 ) {
            return false;
        }
        \DB::beginTransaction();
        foreach ( $prices as $price ) {
            if ( $this->products()
                    ->whereId($price[ 'product_id' ])
                    ->update([ 'sell_price' => $price[ 'sell_price' ] ]) < 0
            ) {
                \DB::rollBack();
                return false;
            }
        }
        \DB::commit();

        return true;
    }

    public static function scopeHasProduct ($query)
    {
        return $query->whereHas('products', function ($q) {
        });
    }

    public static function search ($keyword = '', $category = '', $order = 'created_at', $sort = '')
    {
        $campaigns = Campaign::where('title', 'LIKE', '%' . $keyword . '%');

        $campaign_category = CampaignCategory::whereName($category)->first();

        if ( $campaign_category ) {
            $campaigns = $campaigns->where('campaign_category_id', $campaign_category->id);
        }

        $campaigns = Campaign::hasProduct();

        $campaigns = $campaigns->where('campaign_status_id', CampaignStatus::whereName('open')->first()->id);


        return $campaigns;
    }

    public static function OrderPriceRange ($keyword = '')
    {
        $results = Campaign::with('products')->whereHas('products', function ($q) {
            $q->whereBetween('sell_price', [ 250, 300 ]);
        })->get();

        return $results;

    }

    public static function s ($keyword = '')
    {
        $results = CampaignProduct::distinct([ 'campaign_id' ])->orderBy('sell_price', 'dsc')->get();
        return $results;
    }

    public static function OrderBySellPrice ($keyword = '')
    {
        $results = DB::table('campaigns');
        $results = $results->select([
            'campaigns.id',
            DB::raw('(SELECT MAX(sell_price) from campaign_products WHERE campaign_products.campaign_id = campaigns.id) as `s`')
        ])->orderBy('s', 'dsc');
        $results = $results->where('s', 250)->get([ 's' ]);
        return $results;
    }

    public static function random ($category = '', $product = '', $color = '')
    {

    }

    /**
     * Update product price
     *
     * @param $prices
     * @return bool
     */
    public function updateProductPrice ($prices)
    {
        foreach ( $prices as $price ) {
            $this->products()->whereHas('color', function ($q) use ($price) {
                $q->where('product_id', $price[ 'product_id' ]);
            })->where('is_deleted', false)->update([ 'sell_price' => $price[ 'sell_price' ] ]);
        }

        return true;
    }

    /**
     * Clear all tag
     *
     * @return mixed
     */
    public function clearTag ()
    {
        return CampaignTag::where('campaign_id', $this->id)->delete();
    }

    /**
     * Set campaign status to open
     *
     * @return bool
     */
    public function setOpen ()
    {
        $this->status()->associate(CampaignStatus::open()->first());
        if ( $this->save() ) {
            return true;
        }

        return false;
    }

    public function setActive ()
    {
        $this->status()->associate(CampaignStatus::active()->first());

        if ( $this->save() ) {
            return true;
        }

        return false;
    }
    /**
     * Set campaign status to close
     *
     * @return bool
     */
    public function setClose ()
    {
        $this->status()->associate(CampaignStatus::whereName('close')->first());
        if ( $this->save() ) {
            return true;
        }

        return false;
    }

    /**
     * Get group campaign product by product id
     *
     * @return mixed
     */
    public function getGroupProduct ()
    {
        $products = \DB::table('campaign_products')
            ->rightJoin('product_colors', 'campaign_products.product_color_id', '=', 'product_colors.id')
            ->rightJoin('products', 'product_colors.product_id', '=', 'products.id')
            ->groupBy('product_colors.product_id')->where('campaign_id', $this->id)
            ->where('campaign_products.is_deleted', false)
            ->get([
                'campaign_products.id',
                'product_colors.id as pc_id',
                'product_id',
                'name',
                'sell_price',
                'one_side_price',
                'max_price',
                'campaign_products.image_front_thmb',
                'campaign_products.image_front_medium',
                'campaign_products.image_front_small'
            ]);
        return $products;
    }

    /**
     * Create new url for campaign
     *
     * @param $title
     * @return mixed|string
     */
    public static function createUrl ($title)
    {
        $url = preg_replace("/[&\\/\\\\\\[\\]_#,+()$~%.'\":*?<>{}]/", "", trim($title));
        $url = config('constant.url_prefix') . str_replace(" ", "-", $url);
        $campaign = Campaign::whereTitle($title)->withTrashed()->get();

        if ( $campaign->count() <= 0 ) {
            return $url;
        }

        return $url . '-' . ($campaign->count() + 1);
    }

    /**
     * Get all tag in one line
     *
     * @return string
     */
    public function allTags ()
    {
        $tags = $this->tags;
        $all_tag = '';

        foreach ( $tags as $key => $tag ) {
            $all_tag .= $tag->name . ', ';
        }
        return $all_tag;
    }

    /**
     * Get file from campaign
     *
     * @param $id
     * @param $file_name
     * @return mixed
     */
    public static function file ($id, $file_name)
    {
        if($file_name == '') {
            return '';
        }

        if(!\Storage::disk('local')->has('images/campaigns/' . str_pad($id, 6, 0, STR_PAD_LEFT) . '/' . $file_name)) {
            return null;
        }
        return \Storage::get('images/campaigns/' . str_pad($id, 6, 0, STR_PAD_LEFT) . '/' . $file_name);
    }


    public function available ($campaign)
    {
        return $campaign->where('is_deleted', false);
    }

    public function frontCover ($product_id = '', $size = 'image_front_large')
    {
        $product = $this->products()->where('is_deleted', false);

        if($product_id == '') {
            $product = $product->where('is_primary', true);
        } else {
            $product = $product->where('id', $product_id);
        }

        $product = $product->select($size)->first();

        if(!$product) {
            return null;
        }

        if ( $size == 'image_front_medium' ) {
            return $product->image_front_medium;
        } elseif ( $size == 'image_front_small' ) {
            return $product->image_front_small;
        }

        return $product->image_front_large;
    }

    public function backCover ()
    {
        $product = $this->products()->where('is_deleted', false)->where('is_primary', true)->select('image_back')->first();
        return $product->image_back;
    }

    public function primaryPrice ()
    {
        $product = $this->products()->where('is_deleted', false)->where('is_primary', true)->select('sell_price')->first();
        if(!$product) {
            return 0;
        }
        return $product->sell_price;
    }

    public function affiliateLink (Affiliate $affiliate)
    {
        if ( !$affiliate ) {
            return false;
        }

        return rawurldecode(action('CampaignController@showCampaign', [ $this->url ])) . '?affid=' . $affiliate->id;
    }

    public function affiliateIframe (Affiliate $affiliate)
    {
        if ( !$affiliate ) {
            return false;
        }

        return action('HomeController@getProduct', $this->id) . '?affid=' . $affiliate->id;
    }

    // Scope function
    public function scopeCanShow ($query)
    {
        return $query->whereIn('campaign_status_id', [
            CampaignStatus::active()->first()->id,
            CampaignStatus::close()->first()->id,
            CampaignStatus::check()->first()->id
        ])->creatorActive();
    }

    public function scopeCanShowPublic ($query)
    {
        return $query->active()->creatorActive();
    }

    public function scopeCreatorActive ($query)
    {
        return $query->whereHas('user', function($query) {
            $query->whereIn('user_status_id', [
                UserStatus::normal()->first()->id,
                UserStatus::inActive()->first()->id
            ]);
        });
    }
    public function scopeActive ($query)
    {
        return $query->where('campaign_status_id', CampaignStatus::active()->first()->id);
    }
    public function scopeClose ($query)
    {
        return $query->where('campaign_status_id', CampaignStatus::close()->first()->id);
    }
    public function scopeCheck ($query)
    {
        return $query->where('campaign_status_id', CampaignStatus::check()->first()->id);
    }
    public function scopeStatus ($query, $status_name)
    {
        return $query->where('campaign_status_id', CampaignStatus::status($status_name)->first()->id);
    }

    public function scopeOpen ($query)
    {
        return $query->where('campaign_status_id', CampaignStatus::active()->first()->id);
    }

    public function scopeCreatorName ($query, $name)
    {
        return $query->whereHas('user', function ($query) use ($name) {
            $query->where('users.full_name', $name);
        });
    }

    public function scopeId ($query, $id)
    {
        return $query->whereId($id);
    }

    public function scopeTitle ($query, $title)
    {
        return $query->whereTitle($title);
    }

    /**
     * Get profitable order item from campaign
     *
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function getProfitableOrderItem ($start, $end)
    {
        $order_items = $this->order_items()->approvedRange($start, $end);
        return $order_items->orderBy('approved_at')->get();
    }

    public function creatorCommission ()
    {
        $result = 0;
        foreach ( $this->order_items()->hasAffiliate()->commissionApproved()->get() as $index => $order_item ) {
            $result += $order_item->creator_commission;
        }

        return $result;
    }

    public function isActive ()
    {
        return $this->status->name == 'active';
    }

    /*===================================================================================
     * End New system function
     *===================================================================================*/
    public function order_items ()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function status ()
    {
        return $this->belongsTo('App\CampaignStatus', 'campaign_status_id');
    }

    public function type ()
    {
        return $this->belongsTo('App\CampaignType', 'campaign_type_id');
    }

    public function orders ()
    {
        return $this->hasMany('App\Order');
    }

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function products ()
    {
        return $this->hasMany('App\CampaignProduct');
    }

    public function tags ()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function likes ()
    {
        return $this->hasMany('App\CampaignLike');
    }

    public function comments ()
    {
        return $this->hasMany('App\Comment');
    }

    public function payout ()
    {
        return $this->hasMany('App\Payout');
    }
}