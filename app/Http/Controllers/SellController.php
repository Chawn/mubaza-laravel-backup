<?php namespace App\Http\Controllers;

use App\CampaignStatus;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\OrderItem;
use App\OrderStatus;
use App\Payment;
use App\PaymentStatus;
use App\PaymentType;
use App\Product;
use App\ProductColor;
use App\Category;
use App\Campaign;
use App\CampaignText;
use App\CampaignPicture;
use App\CampaignProduct;
use App\CampaignTag;
use App\ShippingAddress;
use App\ShippingStatus;
use App\ShippingType;
use App\Tag;
use App\Order;
use Image;
use Request;
use Session;
use Storage;

class SellController extends Controller
{

    public function __construct()
    {
        $this->middleware('view_count', [ 'only' => 'showCampaign' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $products = Product::all();
        $categories = Category::all();
        $first_product = Product::first();

        return view('design.index', [
            'title' => \Lang::get("messages.create_campaign"),
            'products' => $products,
            'first_product' => $first_product,
            'categories' => $categories,
            'type' => 'sell',
            'step' => 1
        ]);
    }
    public function getStartCampaign()
    {
        return view('sell.start-campaign', [
            'title' => 'ก่อนสร้างแคมเปญ',
        ]);
    }
    public function getNewArtist()
    {
        return view('sell.new-artist', [
            'title' => 'ก่อนสร้างแคมเปญ',
        ]);
    }

    public function getSetSession()
    {
        $inputs = Request::all();
        session([
            'block_count' => $inputs['block_count'],
            'block_cost' => ((int)config('constant.block_unit_cost') * (int)$inputs['block_count']) + config('constant.block_base_cost'),
        ]);
        return redirect(url('sell/set-goal?key=' . $inputs['key']));
    }

    public function getSetGoal()
    {
        $inputs = Request::all();
        if (!\Auth::user()->check()) {
            return redirect(url('user/login?return=sell/set-goal&key=' . \Request::get('key')));
        } else {
            return view('sell.set-goal', [
                'title' => 'ตังเป้าหมายในการขายครั้งนี้',
                'type' => 'sell',
                'step' => 2
            ]);
        }
    }

    public function getMinPrice($unit_price, $goal)
    {
        if (!session('block_cost')) {
            return [ 'success' => false, 'message' => 'ไม่มีค่าของราคาบล็อกในระบบ', 'value' => 0 ];
        }

        if (!session('block_count')) {
            return [ 'success' => false, 'message' => 'ไม่มีค่าของจำนวนบล็อกในระบบ', 'value' => 0 ];
        }

        $block_cost = session('block_cost');
        $block_count = session('block_count');
        $screen_cost = (config('constant.printing_unit_cost') * $block_count) * $goal;
        $total_product_cost = $unit_price * $goal;

        $min_price = round(($block_cost + $total_product_cost + $screen_cost) / $goal);

        return [ 'success' => true, 'message' => 'Success', 'value' => $min_price ];
    }

    public function getMinProduce($unit_price, $sell_price)
    {
        if (!session('block_cost')) {
            return [ 'success' => false, 'message' => 'ไม่มีค่าของราคาบล็อกในระบบ', 'value' => 0 ];
        }

        if (!session('block_count')) {
            return [ 'success' => false, 'message' => 'ไม่มีค่าของจำนวนบล็อกในระบบ', 'value' => 0 ];
        }

        $sell = intVal($sell_price);

        if ($unit_price > $sell) {
            return [ 'success' => false, 'message' => 'ราคาขายน้อยกว่าราคาเสื้อ' ];
        }

        $block_cost = session('block_cost');
        $block_count = session('block_count');
        for ($goal = 1; $goal <= 1000; $goal++) {
            $screen_cost = (config('constant.printing_unit_cost') * $block_count) * $goal;
            $total_product_cost = $unit_price * $goal;

            $min_price = round(($block_cost + $total_product_cost + $screen_cost) / $goal);
            if ($min_price < $sell) {
                $profit = ($sell - $min_price) * $goal;
//                echo($goal . " - " . $unit_price . " - " . $total_product_cost . " - " . $min_price . " - " . $sell_price . " - " . $profit . " ; ");
                if ($profit > config('constant.profit_to_produce')) {
                    return response()->json([ 'success' => true, 'minimum_order' => $goal ]);
                }
            }
        }

        return response()->json([ 'success' => true, 'minimum_order' => null ]);

    }

    public function getSetDetail()
    {
        return view('sell.set-detail', [
            'title' => 'ใส่รายละเอียด',
            'type' => 'sell',
            'step' => 3
        ]);
    }

    public function showCampaign($url)
    {
        $campaign = Campaign::where('url', $url)
            ->whereIn('campaign_status_id', [
                CampaignStatus::whereName('running')->first()->id,
                CampaignStatus::whereName('close')->first()->id,
                CampaignStatus::whereName('cancel')->first()->id
            ])
            ->with([
                'comments' => function ($query) {
                    $query->orderBy('updated_at', 'asc');
                }, 'user'
            ])
            ->first();

        if ($campaign) {
            $related_campaigns = Campaign::orderBy('created_at', 'desc')->where('user_id', $campaign->user->id)->take(3)->get();

            return view('campaign.product-new', [
                'title' => $campaign->title,
                'campaign' => $campaign,
                'related_campaigns' => $related_campaigns
            ]);
        }

        return view('errors.campaign-not-found', [ 'title' => 'Campaign Not Found' ]);
    }

    public function getProductColor($id)
    {
        $campaign_product = CampaignProduct::find($id);
        $product = $campaign_product->product;
        $colors = [ ];
        foreach ($product->image as $key => $value) {
            array_push($colors, $value->getColorWithoutSharp());
        }

        return response()->json($colors);
    }

    public function getChangeProductColor($id, $color)
    {
        $campaign_product = CampaignProduct::find($id);
        $product_image = ProductColor::where('product_id', $campaign_product->product->id)->where('color', '#' . $color)->get();

        return response()->json($product_image[0]);
    }

    public function getAvailableSizeByCampaignProduct($id)
    {
        $product = CampaignProduct::find($id)->product;

        return response()->json($product->available_size);
    }

    public function getAvailableColorByCampaignProduct($id)
    {
        $product = CampaignProduct::find($id)->product;

        return response()->json($product->image);
    }

    public function getChangeCampaignProduct($id)
    {
        $campaign_product = CampaignProduct::find($id);
        $product = $campaign_product->product;
        $designed_image = [
            'front' => $campaign_product->campaign->image_front,
            'back' => $campaign_product->campaign->image_back,
            'left' => $product->outline->outline_left,
            'top' => $product->outline->outline_top,
            'width' => $product->outline->outline_width,
            'height' => $product->outline->outline_height,
            'back_cover' => $campaign_product->campaign->back_cover
        ];

        return response()->json($designed_image);
    }

    public function getAvailableProduct($id)
    {
        $campaign = Campaign::find($id);
        $campaign_products = $campaign->products;
        $data = [ ];
        foreach ($campaign_products as $key => $campaign_product) {
            $item = [ ];
            $product = $campaign_product->product;
            $color = [ ];

            $item['product_id'] = $product->id;
            $item['name'] = $product->name;
            $item['image'] = $product->getCover();
            $item['sell_price'] = $campaign_product->sell_price;
//            dd(explode);
            $item['available_sizes'] = explode(',', $product->available_size);

            foreach ($product->image as $id => $image) {
                array_push($color, $image->color);
            }

            $item['available_color'] = $color;
            array_push($data, $item);
        }

        return response()->json($data);
    }

    public function getCampaignProduct($id)
    {
        $campaign = Campaign::find($id);
        $campaign_products = $campaign->products;
        $data = [ ];
        foreach ($campaign_products as $key => $campaign_product) {
            $item = [ ];
            $product = $campaign_product->product;
            $color = [ ];

            $item['product_id'] = $product->id;
            $item['name'] = $product->name;
            $item['image'] = $product->getCover()->image_front;
            $item['sell_price'] = $campaign_product->sell_price;
//            dd(explode);
            $item['available_sizes'] = explode(',', $product->available_size);

            foreach ($product->image as $id => $image) {
                array_push($color, $image->color);
            }

            $item['available_color'] = $color;
            $data[$campaign_product->id] = $item;
        }

        return response()->json($data);
    }

    public function postSaveOrder()
    {
        $inputs = Request::all();
        $order = [
            'campaign_id' => $inputs['orders']['campaign_id'],
            'payment_type_id' => $inputs['orders']['payment_type_id'],
            'total' => 0,
            'items' => [ ]
        ];
        foreach ($inputs['orders']['items'] as $index => $item) {
            $campaign_product = CampaignProduct::find($item['campaign_product_id']);
            $sub_total = intval($item['qty']) * $campaign_product->sell_price;
            $order['total'] += $sub_total;
            $order_item = [
                'name' => $campaign_product->product->name,
                'sell_price' => $campaign_product->sell_price,
                'color' => $campaign_product->product_image->color_name,
                'size' => $item['size'],
                'qty' => $item['qty'],
                'sub_total' => $sub_total,
                'campaign_product_id' => $campaign_product->id,
                'image_front' => $campaign_product->product_image->image_front,
                'image_back' => $campaign_product->product_image->image_back,

            ];
            array_push($order['items'], $order_item);
        }

        session([ 'order' => $order ]);

        return response()->json([
            'success' => true,
            'redirect_url' => action('SellController@getCheckout')
        ]);
    }

    public function getCalShippingCost($type)
    {
        $qty = \Session::get('total_qty');

        $cost = Order::calShippingCost($type, $qty);

        return response()->json([ 'cost' => $cost ]);

    }

    public function getCheckout()
    {

        if (!\Auth::user()->check()) {
            return redirect(url('user/login?return=sell/checkout'));
        } else {
            $order = session('order');
            $campaign = Campaign::find($order['campaign_id']);
            $shipping_all = ShippingType::all();
            $shipping_kerry = ShippingType::whereName('kerry')->get();

            $total_qty = 0;
            foreach ($order['items'] as $item) {
                $total_qty = $total_qty + $item['qty'];
            }

            if ($total_qty < 10) {
                $shipping_types = $shipping_all;
            } else {
                $shipping_types = $shipping_kerry;
            }
            Session::put('total_qty', $total_qty);

            return view('order.checkout-sell', [
                'title' => 'ยืนยันการสั่งซื้อสินค้า',
                'order' => $order,
                'total_qty' => $total_qty,
                'shipping_types' => $shipping_types,
                'campaign' => $campaign,
            ]);
        }

    }

    public function postConfirmOrder()
    {
        $inputs = Request::all();
//        dd($inputs);
        $order_data = session('order');
        $user = \Auth::user()->user();
        $order = Order::create([
            'user_id' => $user->id,
            'order_status_id' => OrderStatus::whereName('open')->first()->id,
            'campaign_id' => $order_data['campaign_id'],
            'shipping_status_id' => ShippingStatus::whereName('waiting')->first()->id,
            'shipping_type_id' => ShippingType::whereName($inputs['shipping_type'])->first()->id,
            'payment_status_id' => PaymentStatus::whereName('waiting')->first()->id,
            'payment_type_id' => PaymentType::whereName($inputs['payment_type'])->first()->id
        ]);
//        dd($inputs);
        $sub_total = 0;
        if ($order) {
            foreach ($order_data['items'] as $key => $value) {
                $order_item = OrderItem::create([
                    'campaign_product_id' => $value['campaign_product_id'],
                    'size' => $value['size'],
                    'qty' => $value['qty'],
                    'order_id' => $order->id
                ]);

                $sub_total += CampaignProduct::sumPrice($value['campaign_product_id'], intVal($value['qty']));
            }
            $order->sub_total = $sub_total + $order->shippingCost();
            $order->shipping_cost = $order->shippingCost();

            $order->update();
            $shipping_data = $inputs['shipping'];
            $shipping = ShippingAddress::create([
                'full_name' => $shipping_data['full_name'],
                'address' => $shipping_data['address'],
                'building' => $shipping_data['building'],
                'district' => $shipping_data['district'],
                'province' => $shipping_data['province'],
                'zipcode' => $shipping_data['zipcode'],
                'phone' => $shipping_data['phone'],
                'email' => $shipping_data['email'],
                'order_id' => $order->id
            ]);

            $payment = Payment::create([
                'order_id' => $order->id
            ]);

            if ($inputs['payment_type'] == 'transfer') {
                $this->sendEmailOrderByTransfer($order->id, $order->campaign->id);
            }

            return response()->json([
                'result' => 'success',
                'redirect_url' => action(
                    'SellController@getOrderSuccess',
                    [ 'order_id' => $order->id ]
                )
            ]);
        }
        return false;
    }

    function sendEmailOrderByTransfer($order_id, $campaign_id)
    {
        $order = Order::find($order_id);
        $campaign = Campaign::find($campaign_id);
        $order_id = str_pad($order->id, 6, 0, STR_PAD_LEFT);
        $email = $order->user->email;
        $full_name = $order->user->full_name;
        \Mail::queue('backend.mail.sell-wait', [
            'order_id' => $order_id,
            'campaign_title' => $campaign->title,
            'close_date' => $campaign->getEndDate()->format('d F Y'),
            'sub_total' => number_format($order->subTotal(), 2)
        ], function ($m) use ($email, $full_name, $order_id) {
            $m->to($email, $full_name)->subject('ยืนยันการสั่งซื้อเลขที่ : ' . $order_id);
        });
    }

    public function getOrderSuccess($order_id)
    {
        $order = Order::find($order_id);
        if ($order->payment_status->name === 'waiting') {
            if ($order->payment_type->name === 'transfer') {
                return view('order.checkout_payment', [
                    'title' => 'ยืนยันการชำระเงินด้วยการโอนผ่านธนาคาร',
                    'order' => $order
                ]);
            } elseif ($order->payment_type->name === 'card') {
                return view('order.checkout_card', [
                    'title' => 'ยืนยันการชำระเงินด้วยบัตรเครดิตหรือบัตรเดบิต',
                    'order' => $order
                ]);
            }
        }

        return redirect()->action('UserController@getOrderHistory');
    }

    public function postSaveCard()
    {
        if (!\Request::has('omise_token')) {
            return redirect()->back()->withErrors([ 'เกิดปัญหาในการการบันทึกข้อมูลบัคร' ]);
        }
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));

        $inputs = Request::all();
        $order = Order::find($inputs['order_id']);

        if (!$order) {
            return redirect()->back()->withErrors([ 'ไม่พบรายการสั่งซื้อ' ]);
        }
        if ($order->payment_status->name != 'waiting') {
            return redirect()->back()->withErrors([ 'ไม่สามารถทำการบันทึกข้อมูลได้กรุณาลองใหม่' ]);
        }
        $sub_total = $order->subTotal();

        $customer = \OmiseCustomer::create(array(
            'email' => \Auth::user()->user()->full_name,
            'description' => \Auth::user()->user()->full_name,
            'card' => $inputs['omise_token']
        ));

        $order->payment_status()->associate(PaymentStatus::whereName('paid_by_card')->first());
        $order->payment->first()->transaction_id = $customer['id'];
        $order->payment->first()->pay_on = \Carbon::now();
        $order->payment->first()->from_bank = $customer['cards']['data'][0]['brand'];
        $order->payment->first()->save();

        if ($order->save()) {
            $this->sendOrderByCard($order->id);

            return redirect()->action('UserController@getOrderHistory', $order->user->id)->with('message', 'สั่งซื้อเสร็จเรียบร้อย');
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);

    }

    public function postChargeCard()
    {
        if (!\Request::has('omise_token')) {
            return redirect()->back()->withErrors([ 'เกิดปัญหาในการการบันทึกข้อมูลบัคร' ]);
        }
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));

        $inputs = Request::all();

        $order = Order::find($inputs['order_id']);
        if (!$order) {
            return redirect()->back()->withErrors([ 'ไม่พบรายการสั่งซื้อ' ]);
        }
        if ($order->payment_status->name != 'waiting') {
            return redirect()->back()->withErrors([ 'ไม่สามารถทำการบันทึกข้อมูลได้กรุณาลองใหม่' ]);
        }

        $sub_total = $order->subTotal();
        $card = OmiseCharge::create([
            'amount' => number_format($sub_total, 2, '', ''),
            'currency' => 'thb',
            'description' => 'Order-' . str_pad($inputs['order_id'], 6, '0', STR_PAD_LEFT),
            'return_uri' => action('OrderController@getComplete', $order->id),
            'card' => $inputs['omise_token']
        ]);

        if (!$card['failure_code']) {
            $payment = $order->payment->first();
            $payment->total = $sub_total;
            $payment->pay_on = date('Y-m-d h:m:s');
            $payment->transaction_id = $card['transaction'];
            $payment->from_bank = $card['card']['brand'];
            $payment->save();
            $order->payment_status()->associate(PaymentStatus::whereName('paid')->first());

            $order->save();

            return view('order.che`ckout_success', [
                'title' => 'สั่งซื้อเสร็จเรียบร้อยแล้ว !'
            ]);
        }
        return redirect()->back()->withErrors([ 'เกิดปัญหาในการการบันทึกข้อมูลบัคร' ]);

    }

    function sendOrderByCard($order_id)
    {
        $order = Order::where('id', $order_id)->with('shipping_address', 'allItems', 'allItems.item')->first();

        \Mail::queue('backend.mail.design-success', [
            'order' => $order,
            'user' => $order->user
        ], function ($m) use ($order) {
            $m->to($order->user->email, $order->user->full_name)->subject('ยืนยันการสั่งซื้อเลขที่ : ' . str_pad($order->id, 6, '0', STR_PAD_LEFT));
        });
    }

    public function checkUrl($url)
    {
        $slug = str_slug($url, '-');
        $campaign = Campaign::where('url', $slug)->get();

        if (count($campaign)) {
            return FALSE;
        }

        return TRUE;
    }

    public function getRefund($order_id)
    {

    }

    function calMinPrice($block_cost, $block_count, $unit_price, $goal)
    {
        $block_price = $block_count * $block_cost;

        return round((($unit_price * $goal) + $block_price) / $goal);
    }

    public function getBaseCost()
    {
        return response()->json([
            'printing_unit_cost' => config('constant.printing_unit_cost'),
            'block_unit_cost' => config('constant.block_unit_cost'),
            'block_base_cost' => config('constant.block_base_cost')
        ]);
    }

    public function postRealPrice($product_id, $front = 0, $back = 0)
    {
        $product = Product::find($product_id);

        if(\Request::has('campaign_id'))
        {
            $campaign = Campaign::find(\Request::get('campaign_id'));
            $front = $campaign->design->front_design;
            $back = $campaign->design->back_design;
        }

        $base_price = ($front + $back) * 50;
        return response()->json(['price' => intVal($product->price + $base_price)]);
    }
}
