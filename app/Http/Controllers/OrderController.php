<?php namespace App\Http\Controllers;

use App\CampaignText;
use App\Cart;
use App\CartItem;
use App\Coupons;
use App\Http\Requests;
use App\Lib\Ggseven\OrderListenerInterface;
use App\NotificationType;
use App\Order;
use App\OrderProduceStatus;
use App\OrderStatus;
use App\PaymentStatus;
use App\PaymentType;
use App\redeem_coupons;
use App\ShippingAddress;
use App\ShippingType;
use DB;
use OmiseCharge;
use OmiseCustomer;
use Auth;
use Request;
use Storage;

class OrderController extends Controller implements OrderListenerInterface
{
    public function __construct ()
    {
        $this->middleware('userauth', [
            'except' => [
                'getCart',
                'postAddToCart',
                'getAddToCart',
                'getCartHtml',
                'getCartQty',
                'getRemoveFromCart',
                'getRemoveItem',
                'postUpdateCart'
            ]
        ]);
    }

    public function getOrderTracking ()
    {


        return redirect()->action('UserController@getOrderHistory');
    }

    public function getOrderSuccess ($order_id)
    {
        $order = Order::find($order_id);
        if ( $order->payment_status->name === 'waiting' ) {
            if ( $order->payment_type->name === 'transfer' ) {
                return view('order.checkout_payment', [
                    'title' => 'ยืนยันการชำระเงินด้วยการโอนผ่านธนาคาร',
                    'order' => $order,
                    'type'  => 'design',
                    'step'  => 3
                ]);
            } elseif ( $order->payment_type->name === 'card' ) {
                return view('order.checkout_card', [
                    'title' => 'ยืนยันการชำระเงินด้วยบัตรเครดิตหรือบัตรเดบิต',
                    'order' => $order,
                    'type'  => 'design',
                    'step'  => 3
                ]);
            }
        }

        return redirect()->action('UserController@getOrderHistory');
    }

    public function postSaveCard ()
    {
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));

        $inputs = Request::all();

        $order = Order::find($inputs[ 'order_id' ]);

        if ( $order && $order->payment_status->name === 'waiting' ) {
            $sub_total = $order->subTotal();

            $customer = OmiseCustomer::create(array(
                'email'       => \Auth::user()->user()->full_name,
                'description' => \Auth::user()->user()->full_name,
                'card'        => $inputs[ 'omise_token' ]
            ));

            $order->payment_status()->associate(\App\PaymentStatus::whereName('paid_by_card')->first());
            $order->payment->first()->transaction_id = $customer[ 'id' ];
            $order->payment->first()->pay_on = \Carbon::now();
            $order->payment->first()->from_bank = $customer[ 'cards' ][ 'data' ][ 0 ][ 'brand' ];
            $order->payment->first()->save();
            if ( $order->save() ) {
                $this->sendOrderByCard($order->id);

                return redirect()->action('UserController@getOrderHistory', $order->user->id)->with('message', 'สั่งซื้อเสร็จเรียบร้อย');
            }
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);
    }


    function sendOrderByCard ($order_id)
    {
        $order = Order::where('id', $order_id)->with('shipping_address', 'allItems', 'allItems.item')->first();

        \Mail::queue('backend.mail.design-success', [
            'order' => $order,
            'user'  => $order->user
        ], function ($m) use ($order) {
            $m->to($order->user->email, $order->user->full_name)->subject('ยืนยันการสั่งซื้อเลขที่ : ' . str_pad($order->id, 6, '0', STR_PAD_LEFT));
        });
    }

    public function postChargeCard ()
    {
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));

        $inputs = Request::all();

        $order = Order::find($inputs[ 'order_id' ]);
        if ( $order ) {
            if ( $order->payment_status_id === \App\PaymentStatus::whereName('waiting')->first()->id ) {

                $sub_total = $order->subTotal();
                $card = OmiseCharge::create([
                    'amount'      => number_format($sub_total, 2, '', ''),
                    'currency'    => 'thb',
                    'description' => 'Order-' . str_pad($inputs[ 'order_id' ], 6, '0', STR_PAD_LEFT),
                    'return_uri'  => action('OrderController@getComplete', $order->id),
                    'card'        => $inputs[ 'omise_token' ]
                ]);

                if ( !$card[ 'failure_code' ] ) {
                    $payment = $order->payment->first();
                    $payment->total = $sub_total;
                    $payment->pay_on = date('Y-m-d h:m:s');
                    $payment->transaction_id = $card[ 'transaction' ];
                    $payment->from_bank = $card[ 'card' ][ 'brand' ];
                    $payment->save();
                    $order->payment_status()->associate(\App\PaymentStatus::whereName('paid')->first());

                    $order->save();

                    return view('order.checkout_success', [
                        'title' => 'สั่งซื้อเสร็จเรียบร้อยแล้ว !'
                    ]);
                }
            }
        } else {
            abort(404);
        }
    }

    function sendUpdateTransfer ($id)
    {
        $order = Order::find($id);
        $order_id = str_pad($id, 6, 0, STR_PAD_LEFT);
        $email = $order->user->email;
        $full_name = $order->user->full_name;
        \Mail::queue('backend.mail.payment-success', [
            'order_id'       => $order_id,
            'campaign_title' => $order->campaign->title,
            'user_full_name' => $full_name,
            'close_date'     => $order->campaign->getEndDate()->format('d F Y'),
        ], function ($m) use ($email, $full_name, $order_id) {
            $m->to($email, $full_name)->subject('การแจ้งชำระเงินเลขที่สั่งซื้อ ' . $order_id);
        });
    }

    public function getOrderItemById ($id)
    {
        $order = Order::find($id);
        $items = $order->allItems()->with('item')->get();

        if ( $items ) {
            foreach ( $items as $index => $item ) {
                $items[ $index ][ 'product' ] = $item->item->product;
                $items[ $index ][ 'product_image' ] = $item->product_image;
            }

            return response()->json([
                'success' => TRUE,
                'message' => 'Success',
                'items'   => $items
            ]);
        }

        return response()->json([
            'success' => FALSE, 'message' => 'ไม่สามารถโหลดข้อมูลการสั่งซื้อได้', 'items' => NULL
        ]);
    }

    public function getCheckOrderClosed ($order_id)
    {
        $order = Order::where('id', $order_id)->with('campaign')->first();

        if ( $order ) {
            $campaign = $order->campaign;

            if ( $campaign->isRunning() ) {
                return response()->json([ 'error' => FALSE, 'running' => TRUE ]);
            }
        } else {
            return response()->json([ 'error' => true, 'message' => 'ไม่พบหมายเลขสั่งซื้อนี้ในระบบ' ]);
        }

        return response()->json([
            'error' => true, 'running' => false, 'message' => 'แคมเปญของหมายเลขสั่งซื้อได้จบแล้ว'
        ]);
    }

    public function postOrderPayment ()
    {
        $inputs = \Request::all();
        $orders = Order::with([
            'allItems', 'allItems.item',
            'allItems.item.product',
            'allItems.item.product_image',
            'campaign', 'campaign.type'
        ])->where('user_id', $inputs[ 'user_id' ])
            ->where('payment_status_id', \App\PaymentStatus::whereName('waiting')->first()->id)
            ->get();
        if ( $orders->count() > 0 ) {
            return response()->json($orders);
        }

        return response()->json([ 'error' => true, 'message' => 'ไม่พบรายการสั่งซื้อ' ]);
    }

    public function getCalShippingCost ($type, $qty)
    {
        $cost = Order::calShippingCost($type, $qty);

        return response()->json([ 'cost' => $cost ]);

    }

    public function getCancelOrder ($order_id)
    {
        $order = Order::where('id', $order_id)->first();

        if ( !$order ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลการสั่งซื้อ' ]);
        }

        if ( $order->payment_status->name != 'waiting' ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถยกเลิกการสั่งซื้อได้' ]);
        }

        if( !\OrderService::cancel($order->id, $this) ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถยกเลิกการสั่งซื้อได้' ]);
        }

        return redirect()->action('UserController@getOrderHistory', \Auth::user()->user()->id)->with([ 'message' => 'ยกเลิกการสั่งซื้อเสร็จเรียบร้อย' ]);
    }

    public function getSetSession ()
    {
        $inputs = Request::all();

        session([
            /*'printing_unit_cost' => config('constant.printing_unit_cost'),
            'block_unit_cost' => config('constant.block_unit_cost'),*/
            'block_count' => $inputs[ 'block_count' ],
            'block_cost'  => ((int)config('constant.block_unit_cost') * (int)$inputs[ 'block_count' ]) + config('constant.block_base_cost'),
            'total_qty'   => $inputs[ 'qty' ]
        ]);
        return redirect(url('order/checkout?key=' . $inputs[ 'key' ]));
    }

    /*
     * New system function
     */

    private function CreateCart ($session_id)
    {
        if ( \Auth::user()->check() ) {

        } else {
            $order[ 'cart-id' ] = $session_id;
            $order[ 'items' ] = [ ];

            $order[ 'campaign_id' ] = 1;
            $order[ 'status_id' ] = OrderStatus::whereName('open')->first()->id;
            $order[ 'created_at' ] = \Carbon::now();
            $order[ 'updated_at' ] = \Carbon::now();
            \Session::set('cart', $order);
        }
        return \Session::get('cart');
    }

    public function getRemoveFromCart ($product_id, $product_image_id)
    {
        $cart = \Session::get('cart');

        if ( $cart == null ) {
            return redirect()->back();
        }

        foreach ( $cart[ 'items' ] as $key => $it ) {
            if ( $it[ 'product_id' ] == $product_id && $it[ 'product_image_id' ] == $product_image_id ) {
                unset($cart[ 'items' ][ $key ]);
            }
        }
        $cart[ 'updated_at' ] = \Carbon::now();
        \Session::set('cart', $cart);
    }
//    public function getAddToCart()
//    {
//        $cart = \Session::get('cart');
//
//        if($cart == null)
//        {
//            $session_id = \Session::getId();
//            $cart = $this->CreateCart($session_id);
//        }
//        $item = [
//            'product_id' => 1,
//            'product_name' => 'เสื้อยืด',
//            'product_image_id' => 2,
//            'color' => '#000',
//            'color_name' => 'สีดำ',
//            'sizes' => [
//                'M' => 2,
//                'XL' => 2
//            ],
//            'qty' => 4
//        ];
//        $new_row = true;
//        foreach ($cart['items'] as $key => $it) {
//            if($it['product_id'] == $item['product_id'] && $it['product_image_id'] ==  $item['product_image_id'])
//            {
//                foreach ($item['sizes'] as $size => $qty) {
//                    if(isset($it['sizes'][$size]))
//                    {
//                        $it['sizes'][$size] += $qty;
//                    }
//                    else
//                    {
//                        $it['sizes'][$size] = $qty;
//                    }
//
//                    $it['qty'] += $qty;
//                }
//                $cart['items'][$key] = $it;
//                $new_row = false;
//            }
//        }
//        if($new_row)
//        {
//            array_push($cart['items'], $item);
//        }
//
//        $cart['updated_at'] = \Carbon::now();
//        \Session::set('cart', $cart);
//    }
//    public function getCart()
//    {
//        if(\Auth::user()->check())
//        {
//            return null;
//        }
//        else
//        {
//            $session_id = \Session::getID();
//            $cart = \Session::get('cart');
//            if($cart == null)
//            {
//                return response()->json($this->CreateCart($session_id));
//            }
//            return response()->json(['exists' => $cart]);
//        }
//    }

    /*
     * New function system
     */
    public function postAddToCart ()
    {
        $cart = null;
        if ( !\Request::has('item') ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลสินค้า' ]);
        }
        $item = \Request::get('item');
        if ( \Request::has('cart') ) {
            $cart_data = \Request::get('cart');
            $cart = Cart::whereSessionId($cart_data[ 'session_id' ])->first();

            if ( !$cart ) {
                $cart = Cart::firstOrCreate([
                    'session_id' => \Session::getId()
                ]);
            }
            $cart->addItem($item);
        } else {
            $cart = Cart::firstOrCreate([ 'session_id' => \Session::getId() ]);
            $cart->addItem($item);
        }

        return response()->json([ 'success' => true, 'cart' => $cart ]);
    }

    public function getCart ($cart_id)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return response()->json([
                'cart'  => Cart::create([ 'session_id' => \Session::getId() ]),
                'items' => [ ]
            ]);
        }

        return response()->json([
            'cart'  => $cart,
            'items' => $cart->items()->with('campaign', 'product', 'product.color', 'sku')->get()
        ]);
    }

    public function getCartHtml ($cart_id)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return 'ไม่มีตระสินค้า';
        }

        if ( $cart->items->count() <= 0 ) {
            return '';
        }

        return view('layouts.include.cart-body', [ 'cart' => $cart ]);
    }

    public function getCartQty ($cart_id)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลตะกร้าสินค้า' ]);
        }

        return response()->json([
            'success' => 'true',
            'qty'     => $cart->totalQty(),
            'total' => $cart->total()
        ]);
    }

    /**
     * Remove item from cart
     *
     * @param $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRemoveItem ($item_id)
    {
        $cart_item = CartItem::find($item_id);

        if ( !$cart_item ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลสินค้า' ]);
        }

        if ( !$cart_item->delete() ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่สามารถลบข้อมูลได้' ]);
        }

        return response()->json([ 'success' => true, 'message' => 'ลบข้อมูลเสร็จเรียบร้อย' ]);

    }

    /**
     * Update data item in cart
     *
     * @param $cart_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUpdateCart ($cart_id)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูล' ]);
        }

        if ( !\Request::has('items') ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่มีข้อมูลที่ต้องการอัพเดท' ]);
        }

        $items = \Request::get('items');

        if ( CartItem::RangeUpdate($items) ) {
            return response()->json([ 'success' => true, 'message' => 'อัพเดทข้อมูลเรียบร้อยแล้ว' ]);
        }

        return response()->json([ 'success' => false, 'message' => 'ไม่สามารถอัพเดทข้อมูลได้' ]);
    }

    /**
     * Checkout page
     *
     * @param $cart_id
     * @return mixed
     */
    public function getCheckout ($cart_id)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return redirect()->back()->withErrors([ 'message' => 'ไม่พบข้อมูลตะกร้าสินค้า' ]);
        }

        $total_qty = $cart->totalQty();

        $shipping_types = ShippingType::all();

        if ( $total_qty == 1 ) {
            $shipping_types = ShippingType::all();
        } elseif ( $total_qty >= 2 && $total_qty <= 9 ) {
            $shipping_types = ShippingType::whereIn('name', [ 'ems', 'kerry' ])->get();
        } elseif ( $total_qty >= 10 ) {
            $shipping_types = ShippingType::whereName('kerry')->get();
        }
        return view('order.checkout', [
            'title'          => 'ยืนยันการสั้งซื้อสินค้า',
            'cart'           => $cart,
            'step'           => 'checkout' ,
            'shipping_types' => $shipping_types
        ]);
    }

    public function getComplete ($id)
    {
        $order = Order::find($id);
        return view('order.checkout-success', [
            'title' => 'การสั่งซื้อเสร็จเรียบร้อยแล้ว',
            'step'  => 'complete' ,
            'order' => $order
        ]);
    }

    public function postSaveCheckout ($cart_id)
    {
        $cart = Cart::with('campaign')->whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลตะกร้าสินค้า' ]);
        }

        if(!\Request::has('data')) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลการสั่งซื้อ' ]);
        }

        \Session::set('order_data', \Request::get('data'));

        return response()->json([ 'success' => true, 'redirect_url' => action('OrderController@getCheckoutConfirm', $cart->session_id) ]);
    }

    public function getCheckoutConfirm ($cart_id)
    {
        $cart = Cart::with('campaign')->whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return redirect()->back()->withErrors(['ไม่พบข้อมูลตะกร้าสินค้า' ]);
        }

        if(!\Session::has('order_data')) {
            return redirect()->back()->withErrors(['ไม่พบข้อมูลการสั่งซื้อ' ]);
        }

        return view('order.checkout-confirm', [
            'title' => 'ยืนยันการสั่งซื้อ​',
            'order' => \Session::get('order_data'),
            'cart' => $cart,
            'step' => 'confirm'
        ]);
    }

    public function getConfirmOrder ($cart_id)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return redirect()->back()->withErrors(['ไม่พบข้อมูลตะกร้าสินค้า' ]);
        }

        if(!\Session::has('order_data')) {
            return redirect()->back()->withErrors(['ไม่พบข้อมูลการสั่งซื้อ' ]);
        }

        $order_data = \Session::get('order_data');

        $shipping_type_name = $order_data[ 'shipping_type_id' ];
        $shipping_cost = $this->shippingCost($shipping_type_name, $cart->totalQty());
        DB::beginTransaction();

        $coupon = null;
        $coupon_id =null;
        $coupon_discount_total = 0;
        if($order_data['coupon_code'] != '') {
            $coupon = Coupons::where('coupon_code', $order_data['coupon_code'])->first();
            if($coupon) {
                $coupon_id = $coupon->id;
            }
        }

        $sub_total = $cart->total() + $shipping_cost;
        $coupon_discount_total = floatVal($order_data['coupon_discount_total']);
        $net_total = $sub_total - $coupon_discount_total;


        $order = Order::create([
            'sub_total'                   => $net_total,
            'before_discount_price_total' => $sub_total,
            'net_price_total'             => $net_total,
            'coupon_id'                   => $coupon_id,
            'coupon_discount_total'       => $coupon_discount_total,
            'shipping_cost'               => $shipping_cost,
            'user_id'                     => \Auth::user()->check() ? \Auth::user()->user()->id : null,
            'order_status_id'             => OrderStatus::status(OrderStatus::OPEN)->first()->id,
            'order_produce_status_id'     => OrderProduceStatus::whereName('approve')->first()->id,
            'shipping_type_id'            => ShippingType::whereName($shipping_type_name)->first()->id,
            'payment_status_id'           => PaymentStatus::whereName('waiting')->first()->id,
            'payment_type_id'             => PaymentType::transfer()->first()->id
        ]);

        if ( !$order ) {
            DB::rollback();
            return redirect()->back()->withErrors(['ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้กรุณาลองใหม่']);
        }

        if($coupon) {
            redeem_coupons::useCoupon($coupon->id, \Auth::user()->user()->id, $order->id, 'success',\Request::ip());
        }

        if ( !$order->addItem($cart) ) {
            DB::rollback();
            return redirect()->back()->withErrors(['ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้กรุณาลองใหม่']);
        }

        $shipping_address = new ShippingAddress($order_data[ 'shipping_data' ]);

        if ( !$order->shipping_address()->save($shipping_address) ) {
            DB::rollback();
            return redirect()->back()->withErrors(['ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้กรุณาลองใหม่']);
        }

        if ( !\OrderTrackingService::createOpen($order) ) {
            DB::rollback();
            return redirect()->back()->withErrors(['เกิดข้อผิดพลาดในบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง']);
        }

        if(!\NotificationService::create(
            \Auth::user()->user()->id,
            NotificationType::USER,
            'สั่งซื้อเสร็จแล้วรอการชำระเงิน',
            action('UserController@getShowOrder', [\Auth::user()->user()->getID(), $order->id]
            ))) {
            DB::rollback();
            return redirect()->back()->withErrors(['เกิดข้อผิดพลาดในบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง']);
        }

        // TODO:uncomment for production to delete cart data from db
//        $cart->delete();
        DB::commit();

        return redirect()->action('OrderController@getComplete', $order->id);
    }
    /**
     * Save order data to db
     *
     * @param $cart_id
     * @return mixed
     */
    public function postCheckout ($cart_id)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลตะกร้าสินค้า' ]);
        }

        $inputs = \Request::get('data');

        $shipping_type_name = $inputs[ 'shipping_type_id' ];
        $shipping_cost = $this->shippingCost($shipping_type_name, $cart->totalQty());
        DB::beginTransaction();

        $coupon = null;
        $coupon_id =null;
        $coupon_discount_total = 0;
        if($inputs['coupon_code'] != '') {
            $coupon = Coupons::where('coupon_code', $inputs['coupon_code'])->first();
            if($coupon) {
                $coupon_id = $coupon->id;
            }
        }

        $sub_total = $cart->total() + $shipping_cost;
        $coupon_discount_total = floatVal($inputs['coupon_discount_total']);
        $net_total = $sub_total - $coupon_discount_total;


        $order = Order::create([
            'sub_total'                   => $net_total,
            'before_discount_price_total' => $sub_total,
            'net_price_total'             => $net_total,
            'coupon_id'                   => $coupon_id,
            'coupon_discount_total'       => $coupon_discount_total,
            'shipping_cost'               => $shipping_cost,
            'user_id'                     => \Auth::user()->check() ? \Auth::user()->user()->id : null,
            'order_status_id'             => OrderStatus::whereName('open')->first()->id,
            'order_produce_status_id'     => OrderProduceStatus::whereName('approve')->first()->id,
            'shipping_type_id'            => ShippingType::whereName($shipping_type_name)->first()->id,
            'payment_status_id'           => PaymentStatus::whereName('waiting')->first()->id,
            'payment_type_id'             => PaymentType::transfer()->first()->id,
        ]);
        if ( !$order ) {
            DB::rollback();
            return response()->json([
                'success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้กรุณาลองใหม่'
            ]);
        }
        if($coupon) {
            redeem_coupons::useCoupon($coupon->id, \Auth::user()->user()->id, $order->id, 'success',\Request::ip());
        }
        if ( !$order->addItem($cart) ) {
            DB::rollback();
            return response()->json([
                'success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้กรุณาลองใหม่'
            ]);
        }

        $shipping_address = new ShippingAddress($inputs[ 'shipping_data' ]);

        if ( !$order->shipping_address()->save($shipping_address) ) {
            DB::rollback();
            return response()->json([
                'success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้กรุณาลองใหม่'
            ]);
        }

//        if ( $inputs[ 'payment_type_id' ] == "card" ) {
//            $card = $this->chargeCard($order, $inputs[ 'omise_token' ]);
//            if ( $card == null ) {
//                DB::rollback();
//                return response()->json([
//                    'success' => false, 'message' => 'เกิดข้อผิดพลาดในการชำระเงินกรุณาลองใหม่อีกครั้ง'
//                ]);
//            }
//            if ( !$order->createCardPayment($card) ) {
//                DB::rollback();
//                return response()->json([
//                    'success' => false, 'message' => 'เกิดข้อผิดพลาดในการชำระเงินกรุณาลองใหม่อีกครั้ง'
//                ]);
//            }
//            if ( !$order->setPaid() ) {
//                DB::rollback();
//                return response()->json([
//                    'success' => false, 'message' => 'เกิดข้อผิดพลาดในการชำระเงินกรุณาลองใหม่อีกครั้ง'
//                ]);
//            }
//        }

        if ( !\OrderTrackingService::createOpen($order) ) {
            DB::rollback();
            return response()->json([
                'success' => false, 'message' => 'เกิดข้อผิดพลาดในบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง'
            ]);
        }
        DB::commit();

        // TODO:uncomment for production to delete cart data from db
        $cart->delete();

        return response()->json([
            'success' => true, 'redirect_url' => action('OrderController@getComplete', $order->id)
        ]);

    }

    private function chargeCard (Order $order, $token)
    {
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));
        try {
            $card = OmiseCharge::create([
                'amount'      => number_format($order->subTotal(), 2, '', ''),
                'currency'    => 'thb',
                'description' => 'Order-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'return_uri'  => action('OrderController@getComplete', $order->id),
                'card'        => $token
            ]);

            if ( $card[ 'failure_code' ] == null ) {
                return $card;
            }

            return false;
        } catch ( \Exception $ex ) {
            return false;
        }
    }

    /**
     * Get shipping cost by cart item qty
     *
     * @param $cart_id
     * @param $shipping_type_name
     * @return mixed
     */
    public function getShippingCost ($cart_id, $shipping_type_name)
    {
        $cart = Cart::whereSessionId($cart_id)->first();

        if ( !$cart ) {
            return redirect()->back()->withErrors([ 'message' => 'ไม่พบข้อมูลตะกร้าสินค้า' ]);
        }
        $qty = $cart->totalQty();

        return response()->json([ 'success' => true, 'cost' => $this->shippingCost($shipping_type_name, $qty) ]);
    }

    public function shippingCost ($type, $qty)
    {
        $shipping_types = config('shipping-cost');
        foreach ( $shipping_types[ $type ] as $shipping_type ) {
            if ( $qty >= $shipping_type[ 'min' ] && $qty <= $shipping_type[ 'max' ] ) {
                return $shipping_type[ 'cost' ];
            }
        }

        return 0;
    }

    

    /**
     * Update transferred payment status
     *
     * @return mixed
     * @internal param string $order_id
     */
    public function getUpdatePayment ($order_id = null)
    {
        $orders = \Auth::user()->user()->orders()->transferPayment()->canUpdatePayment()->get();
        return view('order.update-payment', [
            'title'  => 'ยืนยันการชำระเงิน',
            'orders' => $orders,
            'selected_id' => $order_id
        ]);
    }

    /**
     * Save payment data to database
     *
     * @return mixed
     */
    public function postUpdatePayment ()
    {
        $inputs = \Request::all();
        $order = Order::find($inputs[ 'order_id' ]);

        if ( !$order ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลการสั่งซื้อเลขที่: ' . $inputs[ 'order_id' ] ]);
        }

        if ( $order->payment_status->name == 'paid' ) {
            return redirect()->back()->withErrors([ 'การสั่งซื้อเลขที่: ' . $inputs[ 'order_id' ] . ' ชำระเงินเรียบร้อยแล้วกรุณาตรวจสอบใหม่' ]);
        }

        if ( \Request::hasFile('slip_upload') ) {
            if ( !$inputs[ 'slip_upload' ]->isValid() ) {
                return response()->redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์กรุณาลองใหม่' ]);
            }
            $mime = $inputs[ 'slip_upload' ]->getMimeType();
            $mime_type = config('constant.allow_mime_type');

            if ( !in_array($mime, $mime_type) ) {
                return redirect()->back()->withErrors([ 'ภาพโปรไฟล์ของคุณต้องเป็นประเภท JPG หรือ PNG เท่านั้น' ]);
            }

            if ( $inputs[ 'slip_upload' ]->getSize() > 5242880 ) {
                return redirect()->back()->withErrors([ 'ขนาดไฟลต้องมีขนาดไม่เกิน 5 Mb' ]);
            }

            $base_folder = 'images/orders/' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            \Storage::makeDirectory('images/orders');

            $ext = $inputs[ 'slip_upload' ]->getClientOriginalExtension();

            $file_name = 'slip-upload-' . uniqid() . '.' . $ext;

            $destination = $base_folder . '/' . $file_name;

            if ( !\Storage::disk('local')->put($destination, \File::get($inputs[ 'slip_upload' ])) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกภาพหลักฐานการโอนเงินได้' ]);
            }

            $inputs[ 'slip_upload' ] = $file_name;
        }

        if ( !$order->createTransferPayment($inputs) ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลการแจ้งชำระเงินได้' ]);
        }

        if ( !$order->approve() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลการแจ้งชำระเงินได้' ]);
        }

        if ( !\OrderTrackingService::createUpdatePayment($order) ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลการแจ้งชำระเงินได้' ]);
        }

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลการแจ้งชำระเงินเรียบร้อย' ]);
    }


    public function getCustomerReceived ($order_id)
    {
        $order = Order::find($order_id);

        if ( !$order ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลการสั่งซื้อเลขที่: ' . $order_id ]);
        }

        if ( !\OrderTrackingService::createReceived($order) ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว' ]);
    }

    public function postRedeemCoupon ()
    {
        $user_id = \Auth::user()->user()->id;

        if ( !\Request::has('coupon_code') ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่มีรหัสส่วนลด' ]);
        }

        $coupon_code = \Request::get('coupon_code');

        if ( !\Request::has('cart_id') ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่มีข้อมูลตะกร้าสินค้า' ]);
        }

        $cart = Cart::whereSessionId(\Request::get('cart_id'))->first();

        if ( !$cart ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่มีข้อมูลตะกร้าสินค้า' ]);
        }

        $totalPrice = $cart->total();
        $coupon = Coupons::checkCode($coupon_code, $user_id, $cart->total());

        if ( !$coupon ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบรหัสส่วนลด' ]);
        }

        $coupon_discount_total = 0;
        if ( count($coupon) <= 0 && !$coupon ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบรหัสส่วนลด' ]);
        }
        // with coupon
        $coupon = $coupon[ 0 ];
        $discountPrice = 0;
        if ( $coupon->coupon_discount_type == 'price' ) {
            // discount price
            $discountPrice = $coupon->coupon_discount_number;
            if ( $discountPrice > $totalPrice ) {
                $discountPrice = $totalPrice;
            }
//            $coupon_discount_total = $discount;
        } else {
            // discount percent
            $discountPrice = ($coupon->coupon_discount_number * $totalPrice / 100);
            if ( $discountPrice > $totalPrice ) {
                $discountPrice = $totalPrice;
            }
        }
        $coupon_discount_total = $discountPrice;

        return response()->json([
            'success'               => true,
            'coupon_code'           => $coupon_code,
            'coupon_discount_total' => $coupon_discount_total
        ]);
//        \Session::set('coupon_code', \Request::get('coupon_code'));
//        \Session::set('discount_total', $coupon_discount_total);
    }
    /*
     * End new function system
     */
    public function onOrderNotFound ()
    {
        return redirect()->back()->withError([ 'ไม่พบข้อมูลการสั่งซื้อ' ]);
    }

    public function onUpdatePaymentComplete ($message = '')
    {
        // TODO: Implement onUpdatePaymentComplete() method.
    }

    public function onCancelPaymentComplete ($message = '')
    {
        // TODO: Implement onCancelPaymentComplete() method.
    }

    public function onResetPaymentComplete ($message = '')
    {
        // TODO: Implement onResetPaymentComplete() method.
    }

    public function onUpdatePaymentFail ($message = '')
    {
        // TODO: Implement onUpdatePaymentFail() method.
    }

    public function onCancelPaymentFail ($message = '')
    {
        // TODO: Implement onCancelPaymentFail() method.
    }

    public function onResetPaymentFail ($message = '')
    {
        // TODO: Implement onResetPaymentFail() method.
    }

    public function onReturnOrderComplete ($message = '')
    {
        // TODO: Implement onReturnOrderComplete() method.
    }

    public function onReturnOrderFail ($message = '')
    {
        // TODO: Implement onReturnOrderFail() method.
    }

    public function onUpdateOrderFail ($message)
    {
        // TODO: Implement onUpdateOrderFail() method.
    }

    public function onUpdateOrderComplete ($message)
    {
        // TODO: Implement onUpdateOrderComplete() method.
    }
}