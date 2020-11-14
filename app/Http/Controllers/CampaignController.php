<?php namespace App\Http\Controllers;

use App\Affiliate;
use App\CampaignLike;
use App\CampaignCategory;
use App\CampaignProduct;
use App\CampaignStatus;
use App\CampaignTag;
use App\CampaignType;
use App\CampaignWishList;
use App\Comment;
use App\CommentLike;
use App\Http\Requests;
use App\Campaign;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\Payment;
use App\PaymentStatus;
use App\PaymentType;
use App\Product;
use App\ProductColor;
use App\ShippingAddress;
use App\ShippingType;
use App\Tag;
use App\User;
use App\UserFollow;
use Auth;
use Carbon;
use Mail;
use Request as InputRequest;
use Storage;

class CampaignController extends Controller
{
    private $request;
    public function __construct (\Request $request)
    {
        $this->middleware('click_stat', [ 'only' => 'showCampaign' ]);
        $this->middleware('last_viewed', [ 'only' => 'showCampaign' ]);
        $this->request = $request;
    }

    public function getShow ($campaign_id)
    {
        $campaign = Campaign::whereId($campaign_id)->open()
            ->with([
                'comments' => function ($query) {
                    $query->orderBy('updated_at', 'asc');
                }, 'user'
            ])
            ->first();
        if ( !$campaign ) {
            return view('errors.campaign-not-found', [ 'title' => 'Campaign Not Found' ]);
        }

        $related_campaigns = Campaign::orderBy('created_at', 'desc')->where('user_id', $campaign->user->id)->take(3)->get();

        return view('campaign.campaign-show', [
            'title'             => $campaign->title,
            'campaign'          => $campaign,
            'related_campaigns' => $related_campaigns
        ]);
    }

    public function getSurprise ()
    {

        return view('campaign.surprise-me', [
            'title' => 'Surprise Me!'
        ]);
    }

//    public function postSave($type = 'sell') {
//        $inputs = \Request::all();
//        $campaign_data = $inputs['campaign'];
//
//        $campaign_type = $type;
//        $user = Auth::user()->user();
//        $end = $campaign_data['end_amount'] != 0 ? Carbon::now()->addDays($campaign_data['end_amount']) : null;
//
//        $campaign = Campaign::create([
//            'title' => $campaign_data['title'],
//            'description' => $campaign_data['description'],
//            'goal' => $campaign_data['goal'],
//            'limit' => $campaign_data['limit'],
//            'end_amount' => $campaign_data['end_amount'],
//            'end' => $end,
//            'back_cover' => $campaign_data['back_cover'],
//            'campaign_type_id' => CampaignType::whereName($campaign_type)->first()->id,
//            'campaign_status_id' => CampaignStatus::whereName('running')->first()->id,
//            'campaign_produce_status_id' => CampaignProduceStatus::whereName('approve')->first()->id,
//            'campaign_shipping_status_id' => CampaignShippingStatus::whereName('waiting')->first()->id,
//            'user_id' => $user->id,
//        ]);
//
//        if(!$campaign)
//        {
//            return response()->json([
//                'success' => false,
//                'message' => 'การบันทึกข้อมูลการออกแบบผิดพลาดกรุณาลองใหม่'
//            ]);
//        }
//        $base_folder = 'campaigns/' . $campaign->id . '/';
//        $original_base_folder = str_replace('storage/', '', $campaign_data['base_folder']);
//        if($campaign_data['image_front'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['image_front'], $base_folder . $campaign_data['image_front']);
//        }
//        if($campaign_data['image_back'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['image_back'], $base_folder . $campaign_data['image_back']);
//        }
//        if($campaign_data['thumbnail_front'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['thumbnail_front'], $base_folder . $campaign_data['thumbnail_front']);
//        }
//        if($campaign_data['thumbnail_back'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['thumbnail_back'], $base_folder . $campaign_data['thumbnail_back']);
//        }
//        if($campaign_data['thumbnail_medium_front'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['thumbnail_medium_front'], $base_folder . $campaign_data['thumbnail_medium_front']);
//        }
//        if($campaign_data['thumbnail_medium_back'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['thumbnail_medium_back'], $base_folder . $campaign_data['thumbnail_medium_back']);
//        }
//        if($campaign_data['thumbnail_mini_front'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['thumbnail_mini_front'], $base_folder . $campaign_data['thumbnail_mini_front']);
//        }
//        if($campaign_data['thumbnail_mini_back'] != '')
//        {
//            $this->copyFile($original_base_folder . $campaign_data['thumbnail_mini_back'], $base_folder . $campaign_data['thumbnail_mini_back']);
//        }
////        dd($campaign);
//        $campaign_design = CampaignDesign::create([
//            'front_design'   => $campaign_data['design']['front_design'],
//            'back_design'    => $campaign_data['design']['back_design'],
//            'image_front'         => $campaign_data['image_front'],
//            'image_back'          => $campaign_data['image_back'],
//            'image_front_preview' => $campaign_data['thumbnail_front'],
//            'image_back_preview'  => $campaign_data['thumbnail_back'],
//            'image_front_preview_medium' => $campaign_data['thumbnail_medium_front'],
//            'image_back_preview_medium'  => $campaign_data['thumbnail_medium_back'],
//            'image_front_preview_thmb' => $campaign_data['thumbnail_mini_front'],
//            'image_back_preview_thmb'  => $campaign_data['thumbnail_mini_back'],
//        ]);
//        if(!$campaign_design)
//        {
//            Campaign::destroy($campaign->id);
//            return response()->json([
//                'success' => false,
//                'message' => 'การบันทึกข้อมูลแคมเปญผิดพลาดกรุณาลองใหม่'
//            ]);
//        }
//
//        $campaign->design()->associate($campaign_design);
//        $campaign->update();
//
//        if (isset($campaign_data['tags'])) {
//            foreach ($campaign_data['tags'] as $tag) {
//                $tag_data = \App\Tag::firstOrCreate(['name' => $tag]);
//                $campaign->tags()->attach($tag_data->id);
//            }
//        }
//
//        if (!isset($campaign_data['design'])) {
//            $campaign->forceDelete();
//            $campaign_design->delete();
//            return response()->json([
//                'success' => false,
//                'message' => 'ไม่พบข้อมูลการออกแบบกรุณาลองออกแบบใหม่'
//            ]);
//        }
//
//        foreach ($campaign_data['design']['items'] as $key => $value) {
//            if ($value['type'] == 'text') {
//                CampaignText::create([
//                    'item_no' => $value['no'],
//                    'text' => $value['text'],
//                    'color' => $value['color'],
//                    'size' => $value['font_size'],
//                    'family' => $value['font_family'],
//                    'location' => $value['location'],
//                    'left' => $value['left'],
//                    'top' => $value['top'],
//                    'rotate' => $value['rotate'],
//                    'z_index' => $value['z_index'],
//                    'campaign_design_id' => $campaign_design->id
//                ]);
//            } else {
//                if ($value['type'] == 'picture') {
//                    Storage::makeDirectory('campaign/' . $campaign->id);
//                    $file_name = explode('.', $value['url']);
//                    $new_image = 'campaigns/' . $campaign->id . '/picture' . $key . '.' . $file_name[1];
//                    Storage::copy(str_replace('storage/', '', $value['url']), $new_image);
//                    CampaignPicture::create([
//                        'item_no' => $value['no'],
//                        'url' => $new_image,
//                        'location' => $value['location'],
//                        'height' => $value['height'],
//                        'width' => $value['width'],
//                        'left' => $value['left'],
//                        'top' => $value['top'],
//                        'rotate' => $value['rotate'],
//                        'z_index' => $value['z_index'],
//                        'campaign_design_id' => $campaign_design->id
//                    ]);
//                }
//            }
//        }
//
//        if($campaign_type === 'buy') {
//            $order_id = $this->saveOrder($campaign_data, $campaign->id);
//            if($campaign_data['payment_type'] == 'transfer')
//            {
//                $this->sendOrderByTransferBank($order_id, $campaign->id);
//            }
//
//            return response()->json([
//                'result'       => 'success',
//                'redirect_url' => action(
//                    'OrderController@getOrderSuccess',
//                    ['order_id' => $order_id]
//                )
//            ]);
//        } elseif($campaign_type === 'sell') {
//            $campaign_products = $campaign_data['product'];
//            foreach ($campaign_products as $key => $campaign_product) {
//                CampaignProduct::create([
//                    'campaign_id'      => $campaign->id,
//                    'product_id'       => $campaign_product['id'],
//                    'product_image_id' => $campaign_product['image_id'],
//                    'sell_price'       => $campaign_product['sell_price']
//                ]);
//            }
//        }
//
////        $this->sendMailToSubscriber($campaign->id);
//
//        if($campaign_type == 'sell')
//        {
//            $this->sendMailCreateNewCampaign($campaign->id);
//        }
//
//        return response()->json([
//            'success' => true,
//            'redirect_url' => action('CampaignController@getShow', $campaign->id)
//        ]);
//    }

//    function copyFile($original, $destination, $move = false)
//    {
//        if (!Storage::exists($original)) {
//            return false;
//        }
//        if ($move) {
//            if(Storage::move($original, $destination))
//            {
//                return true;
//            }
//        } else {
//            if (Storage::copy($original, $destination)) {
//                return true;
//            }
//        }
//        return false;
//    }
    function getMinPrice ($unit_price, $goal)
    {
        if ( !session('block_cost') ) {
            return 0;
        }

        if ( !session('block_count') ) {
            return 0;
        }

        $block_cost = session('block_cost');
        $block_count = session('block_count');
        $screen_cost = (config('constant.printing_unit_cost') * $block_count) * $goal;
        $total_product_cost = $unit_price * $goal;

        $min_price = round(($block_cost + $total_product_cost + $screen_cost) / $goal);

        return $min_price;
    }

    function sendMailCreateNewCampaign ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        $user = $campaign->user;

        Mail::queue('backend.mail.designed', [
            'campaign' => $campaign,
            'user'     => $user
        ], function ($m) use ($user, $campaign) {
            $m->to($user->email, $user->name)->subject('แคมเปญใหม่ของคุณได้สร้างขึ้นแล้ว');
        });
    }

    function copyToCampaign ($source)
    {

    }

    function calSellPrice ($block_cost, $block_count, $qty)
    {
        return round((($block_cost * 5) + ($block_cost * $block_count)) / $qty);
    }

    function calMinPrice ($block_cost, $block_count, $unit_price, $goal)
    {
        $block_price = $block_count * $block_cost;

        return round((($unit_price * $goal) + $block_price) / $goal);
    }

    function saveOrder ($campaign_data, $campaign_id)
    {
        $user = Auth::user()->user();
        $order = Order::create([
            'user_id'            => $user->id,
            'order_status_id'    => OrderStatus::whereName('open')->first()->id,
            'campaign_id'        => $campaign_id,
            'shipping_status_id' => ShippingStatus::whereName('waiting')->first()->id,
            'shipping_type_id'   => ShippingType::whereName($campaign_data[ 'order' ][ 'shipping_type_id' ])->first()->id,
            'payment_status_id'  => PaymentStatus::whereName('waiting')->first()->id,
            'payment_type_id'    => PaymentType::whereName($campaign_data[ 'payment_type' ])->first()->id
        ]);
        if ( $order ) {
            $payment = Payment::create([
                'order_id' => $order->id
            ]);
        }
        if ( $campaign_data[ 'shipping' ] ) {
            $shipping_data = $campaign_data[ 'shipping' ];
            $shipping = ShippingAddress::create([
                'full_name' => $shipping_data[ 'full_name' ],
                'address'   => $shipping_data[ 'address' ],
                'building'  => $shipping_data[ 'building' ],
                'district'  => $shipping_data[ 'district' ],
                'province'  => $shipping_data[ 'province' ],
                'zipcode'   => $shipping_data[ 'zipcode' ],
                'phone'     => $shipping_data[ 'phone' ],
                'email'     => $shipping_data[ 'email' ],
                'order_id'  => $order->id
            ]);
        }
        // Calculate per unit block cost
        $block_cost = session('block_cost');
        $block_count = intVal(session('block_count'));
        $sum_qty = $campaign_data[ 'order' ][ 'sum_qty' ];
        $screen_cost = (config('constant.printing_unit_cost') * $block_count) * $sum_qty;
        $sub_total = 0;
        $shipping_cost = 0;

        foreach ( $campaign_data[ 'order' ][ 'items' ] as $key => $value ) {
            $product = Product::find($value[ 'product_id' ]);
            $total_product_cost = ($sum_qty * $product->price);
            $sell_price = ($block_cost + $screen_cost + $total_product_cost) / $sum_qty;
            $campaign_product = CampaignProduct::create([
                'campaign_id'      => $campaign_id,
                'product_id'       => $value[ 'product_id' ],
                'product_image_id' => $value[ 'image_id' ],
                'sell_price'       => $sell_price,
                'min_price'        => $sell_price
            ]);
            $sub_total += CampaignProduct::sumPrice($campaign_product->id, intVal($value[ 'qty' ]));
            $order_item = OrderItem::create([
                'campaign_product_id' => $campaign_product->id,
                'size'                => $value[ 'size' ],
                'qty'                 => $value[ 'qty' ],
                'order_id'            => $order->id
            ]);
        }
        $order->sub_total = $sub_total + $order->shippingCost();
        $order->shipping_cost = $order->shippingCost();
        $order->update();
        return $order->id;
    }

    public function postSaveStatus ($id)
    {
        $campaign = Campaign::find($id);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        if ( !\Request::has('status_name') ) {
            return response()->json([ 'success' => FALSE, 'message' => 'ไม่พบข้อมูลสถานะแคมเปญกรุณาลองใหม่' ]);
        }

        $status_name = \Request::get('status_name');

        $campaign->produce_status()->associate(CampaignProduceStatus::whereName($status_name)->first());
        if ( $status_name == 'shipping' ) {
            $campaign->produce_end = Carbon::now();
        }
        if ( $campaign->save() ) {
            return response()->json([ 'success' => TRUE, 'message' => 'บันทึกสถานะเสร็จเรียบร้อย' ]);
        }

        return response()->json([ 'success' => FALSE, 'message' => 'ไม่สามารถบันทึกสถานะได้กรุณาลองใหม่' ]);
    }

    public function getDeleteComment ()
    {
        if(!\Request::has('comment_id')) {
            return response()->json(['success' => false, 'message' => 'ไม่มีข้อมูลการแสดงความคิดเห็น']);
        }

        if(!\Request::has('user_id')) {
            return response()->json(['success' => false, 'message' => 'ไม่มีข้อมูลผู้ใช้']);
        }

        $comment_id = \Request::get('comment_id');
        $user_id = \Request::get('user_id');

        $comment = Comment::where('id', $comment_id)->where('user_id', $user_id)->first();

        if ( !$comment ) {
            return response()->json(['success' => false, 'message' => 'ไม่พบความคิดเห็นของคุณ' ]);
        }

        if ( $comment->delete() ) {
            return response()->json(['success' => true, 'message' => 'ลบความคิดเห็นเรียบร้อยแล้ว' ]);
        }

        return response()->json(['success' => false, 'message' => 'ไม่สามารถลบความคิดเห็นได้' ]);
    }

    public function getAvailableProduct ($id)
    {
        $campaign = Campaign::where('id', $id)->with([
            'products' => function ($query) {
                $query->with([ 'product', 'product_image' ]);
            }
        ])->take(1)->get();

        return response()->json($campaign[ 0 ]);
    }

//    public function getSearch($sort = '', $order = '')
//    {
//        $inputs = \Request::all();
//        $keyword = \Request::has('q') ? $inputs['q'] : '';
//        $current_page = (\Request::has('page') ? intVal($inputs['page']) : 1);
//        $results = Campaign::search($keyword, $sort, $order, 12, $current_page);
//        $arr_id = [ ];
//        $data = $results['result']->get([ 'campaigns.id' ]);
//        $next_page = $current_page + 1;
//        $total = $results['total'];
//        if (count($data) < 12) {
//            $next_page = 0;
//        }
////        dd([$current_page, $next_page, $data]);
//        foreach ($data as $item) {
//            array_push($arr_id, $item->id);
//        }
//        $campaigns = Campaign::whereIn('id', $arr_id)->get();
//        return view('search', [
//            'title' => 'ผลการค้นหาของ ' . $keyword,
//            'keyword' => $keyword,
//            'count' => 1,
//            'current_page' => $current_page,
//            'next_page' => $next_page,
//            'campaigns' => $campaigns,
//            'total' => $total
//        ]);
//    }

    /*
     * Social Function
     */

    public function getSetLikeCampaign ($campaign_id, $user_id)
    {
        $campaign_like = CampaignLike::where('campaign_id', $campaign_id)->where('user_id', $user_id)->first();

        if ( $campaign_like ) {
            $campaign_like->delete();
            return response()->json([ 'error' => false, 'message' => 'removed' ]);
        } else {
            CampaignLike::create([
                'campaign_id' => $campaign_id,
                'user_id'     => $user_id
            ]);
        }
        return response()->json([ 'error' => false, 'message' => 'added' ]);
    }

    public function getCampaignLike ($campaign_id)
    {
        return response()->json([ 'error' => false, 'count' => count(Campaign::find($campaign_id)->likes) ]);
    }

    public function getFavoriteCampaign ($campaign_id)
    {

    }

    public function getSetFavoriteCampaign ($campaign_id, $user_id)
    {
        $campaign_favorite = CampaignFavorite::where('campaign_id', $campaign_id)->where('user_id', $user_id)->first();

        if ( $campaign_favorite ) {
            $campaign_favorite->delete();
            return response()->json([ 'error' => false, 'message' => 'removed' ]);
        } else {
            CampaignFavorite::create([
                'campaign_id' => $campaign_id,
                'user_id'     => $user_id
            ]);
        }
        return response()->json([ 'error' => false, 'message' => 'added' ]);
    }

    public function getUserSubscribe ($user_id)
    {
        return response()->json([ 'error' => false, 'count' => count(\App\User::find($user_id)->subscribes) ]);
    }

    public function getSetUserSubscribe ($from_user_id, $to_user_id)
    {
        $user_scribe = UserFollow::where('follower_id', $from_user_id)
            ->where('user_id', $to_user_id)->first();

        if ( $user_scribe ) {
            $user_scribe->delete();
            return response()->json([ 'success' => true, 'message' => 'removed', 'is_subscribed' => 0 ]);
        } else {
            UserFollow::create([
                'follower_id' => $from_user_id,
                'user_id'   => $to_user_id
            ]);
        }
        return response()->json([ 'success' => true, 'message' => 'added', 'is_subscribed' => 1 ]);
    }

    public function getLikeComment ()
    {
        if(!\Request::has('comment_id')) {
            return response()->json(['success' => false, 'message' => 'ไม่มีข้อมูลการแสดงความคิดเห็น']);
        }

        if(!\Request::has('user_id')) {
            return response()->json(['success' => false, 'message' => 'ไม่มีข้อมูลผู้ใช้']);
        }
        $comment_id = \Request::get('comment_id');
        $user_id = \Request::get('user_id');

        $user = User::find($user_id);

        if(!$user) {
            return response()->json(['success' => false, 'message' => 'ไม่มีข้อมูลผู้ใช้']);
        }

        $comment_like = CommentLike::where('comment_id', $comment_id)->where('user_id', $user_id)->first();

        if ( $comment_like ) {
            $comment_like->delete();
            return response()->json([ 'success' => true, 'message' => 'removed' ]);
        } else {
            CommentLike::create([
                'comment_id' => $comment_id,
                'user_id'    => $user_id
            ]);
        }
        return response()->json([ 'success' => true, 'message' => 'added' ]);
    }

    public function getCommentLikeCount ()
    {
        if(!\Request::has('comment_id')) {
            return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลความคิดเห็นนี้']);
        }

        $comment_id = \Request::get('comment_id');

        $comment = Comment::find($comment_id);

        if(!$comment) {
            return response()->json(['success' => false, 'message' => 'ไม่พบข้อมูลความคิดเห็นนี้', 'count' => 0]);
        }
        return response()->json([ 'success' => true, 'count' => count($comment->likes) ]);
    }

    public function postReserve ($campaign_id)
    {
        if ( \Request::has('email') ) {
            $reserve = CampaignReserve::firstOrCreate([
                'email'       => \Request::get('email'),
                'campaign_id' => $campaign_id
            ]);

            if ( $reserve ) {
                $campaign = CampaignReserve::where('campaign_id', $campaign_id)->get();
                if ( count($campaign) >= 10 ) {
                    $this->sendMailOpenCampaignAgain($campaign_id);
                }

                return redirect()->back();
            }
        }

        return redirect()->back()->withErrors([ 'message' => 'กรุณากรอกข้อมูลอีเมล์ด้วย' ]);
    }

    function sendMailOpenCampaignAgain ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        $user = $campaign->user;

        Mail::queue('backend.mail.campaign-start-again', [
            'campaign' => $campaign,
            'user'     => $user
        ], function ($m) use ($user, $campaign) {
            $m->to($user->email, $user->name)->subject('มีคนต้องการขอให้คุณเปิดแคมเปญอีกครั้ง');
        });
    }

    public function getEditDetail ($campaign_id)
    {
        $campaign = Campaign::where('id', $campaign_id)
            ->where('campaign_status_id', CampaignStatus::whereName('running')->first()->id)->first();
        if ( $campaign ) {
            return view('sell.edit-detail', [
                'title'    => 'แก้ไขข้อมูลแคมเปญ ' . $campaign->title,
                'campaign' => $campaign
            ]);
        }

        return view('errors.campaign-not-found');
    }

    public function getEditGoal ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( $campaign->status->name != 'close' ) {
            return 'คุณต้องปิดแคมเปญนี้ก่อนเพื่อดำเนินการต่อไป';
        }

        if ( !$campaign ) {
            return view('errors.campaign-not-found');
        }

        if ( !Auth::user()->user()->isOwner($campaign->user_id) ) {
            return 'Permission deny';
        }

        return view('sell.edit-goal', [
            'title'    => 'แก้ไขเป้าหมายและราคาของแคมเปญ ' . $campaign->title,
            'campaign' => $campaign
        ]);

    }

    /**
     * Save campaign detail data to db
     *
     * @param $campaign_id
     * @return $this|\Illuminate\Http\RedirectResponse|string
     */
    public function postEditDetail ($campaign_id)
    {
        $inputs = \Request::all();

        $campaign = Campaign::find($campaign_id);

        if ( $campaign ) {
            $campaign->title = $inputs[ 'title' ];
            $campaign->description = $inputs[ 'description' ];

            if ( \Request::has('back_cover') ) {
                $campaign->back_cover = $inputs[ 'back_cover' ];
            }

            $campaign->update();
            $tags = explode(',', $inputs[ 'tags' ]);
            $campaign->tags()->detach();
            foreach ( $tags as $tag ) {
                $tag_data = Tag::firstOrCreate([ 'name' => trim($tag) ]);
                $campaign->tags()->attach($tag_data->id);
            }

            return redirect()->action('SellController@showCampaign', $campaign->url);
        }

        return 'Campaign Not Found';
    }


    /**
     * Save campaign goal data to db
     *
     * @param $campaign_id
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function postEditGoal ($campaign_id)
    {
        $inputs = \Request::all();
        $campaign_data = $inputs[ 'campaign' ];

        $campaign = Campaign::find($campaign_id);

        if ( $campaign ) {
            $campaign->goal = $campaign_data[ 'goal' ];
            $campaign->end_amount = $campaign_data[ 'end_amount' ];
            $campaign->start = Carbon::now();
            $campaign->end = Carbon::now()->addDays($campaign_data[ 'end_amount' ]);
            $campaign->status()->associate(CampaignStatus::whereName('running')->first());
            $campaign->products()->delete();

            foreach ( $campaign_data[ 'products' ] as $product ) {
                CampaignProduct::create([
                    'campaign_id'      => $campaign->id,
                    'product_id'       => $product[ 'id' ],
                    'product_image_id' => $product[ 'image_id' ],
                    'sell_price'       => $product[ 'sell_price' ],
                    'min_price'        => $product[ 'unit_price' ]
                ]);
            }

            $campaign->update();

            return response()->json([
                'error'     => false,
                'message'   => 'บันทึกข้อมูลเรียบร้อย',
                'next_step' => action('CampaignController@getEditDetail', $campaign->id)
            ]);
        }

        return view('errors.campaign-not-found', [ 'title' => 'Campaign Not Found' ]);
    }

    public function getReopen ($campaign_id)
    {
        $campaign = Campaign::where('id', $campaign_id)
            ->where('campaign_status_id', CampaignStatus::whereName('close')->first()->id)->first();
        if ( $campaign && Auth::user()->user()->isOwner($campaign->user_id) ) {
            $new_campaign = $campaign->replicate();
            $campaign->url = $campaign->url . '_OLD';
            $campaign->update();
            if ( $new_campaign->save() ) {
                $new_campaign_product = $campaign->products;
                foreach ( $new_campaign_product as $campaign_product ) {
                    $new_product = $campaign_product->replicate();
                    $new_product->campaign_id = $new_campaign->id;
                    $new_product->save();
                }
            }
            return redirect()->action('CampaignController@getEditGoal', $new_campaign->id);
        }

        return view('errors.campaign-not-found', [ 'title' => 'Campaign Not Found' ]);
    }

    public function getSetRecommended ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( $campaign ) {
            $campaign->is_recommended = !($campaign->is_recommended);
            if ( $campaign->update() ) {
                return redirect()->back()->with('message', 'บันทึกแคมเปญแนะนำเรียบร้อยแล้ว');
            }
        }

        return 'Campaign Not Found';
    }

    function sendMailToSubscriber ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        $users = $campaign->user->followers;

        foreach ( $users as $key => $user ) {
            Mail::queue('backend.mail.favorite', [
                'campaign' => $campaign,
                'creator'  => $campaign->user,
                'user'     => $user
            ], function ($m) use ($user, $campaign) {
                $m->to($user->email, $user->name)->subject('แคมเปญใหม่ของคุณ ' . $campaign->user->full_name);
            });
        }
    }

    function sendOrderByTransferBank ($order_id, $campaign_id)
    {
        $order = \App\Order::where('id', $order_id)->with('shipping_address', 'allItems')->first();
        $campaign = Campaign::where('id', $campaign_id)->with('design')->first();
        $order_id = str_pad($order->id, 6, '0', STR_PAD_LEFT);
        $email = $order->user->email;
        $full_name = $order->user->full_name;
        Mail::queue('backend.mail.design-wait', [
            'order_id'                     => $order_id,
            'all_items'                    => $order->allItems,
            'shipping_address'             => $order->shipping_address,
            'campaign_image_front_preview' => $campaign->design->image_front_preview,
            'sub_total'                    => number_format($order->subTotal(), 2),
            'user_email'                   => $order->user->email,
        ], function ($m) use ($email, $full_name, $order_id) {
            $m->to($email, $full_name)->subject('ยืนยันการสั่งซื้อเลขที่ : ' . $order_id);
        });
    }

    public function getCheckUrl ($url)
    {
        return response()->json([ 'success' => Campaign::checkUrl($url) ]);
    }


//    public function getClose($campaign_id)
//    {
//        $campaign = Campaign::find($campaign_id);
//
//        if (!$campaign) {
//            return 'Campaign Not Found';
//        }
//
//        $campaign->status()->associate(CampaignStatus::whereName('close')->first());
//        $campaign->end = Carbon::now();
//        if ($campaign->save()) {
//            return redirect()->back()->with([ 'message' => 'ปิดการขายเรียบร้อยแล้ว' ]);
//        }
//
//        return redirect()->back()->withErrors('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
//    }

    public function postUpdateCampaignProduct ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบแคมเปญนี้กรุณาลองใหม่' ]);
        }

        $items = \Request::get('items');

        foreach ( $items as $key => $item ) {
            CampaignProduct::create($item);
        }

        return response()->json([ 'success' => true, 'message' => 'update successful' ]);
    }

    /*
     * New system function
     */

    public function postSaveDesignToBuy ()
    {
        $inputs = \Request::all();

        if ( !\Request::has('campaign') ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่มีข้อมูลแคมเปญกรุณาลองใหม่' ]);
        }

        $data = $inputs[ 'campaign' ];
        $front_design = intVal($data[ 'design' ][ 'front_design' ]);
        $back_design = intVal($data[ 'design' ][ 'back_design' ]);
        $both_print = false;

        if ( ($front_design + $back_design) == 2 ) {
            $both_print = true;
        }
        \DB::beginTransaction();

        $campaign = null;

        if ( $data[ 'id' ] != null ) {
            $campaign = Campaign::find($data[ 'id' ]);

            if ( !$campaign ) {
                // If campaign not found set null to id and continue
                $data[ 'id' ] = null;
            }
        }

        if ( $data[ 'id' ] == null ) {
            $campaign = Campaign::create([
                'start'              => Carbon::now(),
                'end'                => Carbon::now(),
                'both_print'         => $both_print,
                'campaign_type_id'   => CampaignType::whereName('buy')->first()->id,
                'campaign_status_id' => CampaignStatus::whereName('close')->first()->id,
                'user_id'            => \Auth::user()->check() ? \Auth::user()->user()->id : null
            ]);
        }

        $campaign->products()->delete();

        $product = Product::find($data[ 'product' ][ 0 ][ 'id' ]);
        if ( !$product ) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลสินค้าที่เลือก'
            ]);
        }
        $campaign_product = new CampaignProduct();
        $campaign_product->product_color_id = $data[ 'product' ][ 0 ][ 'color_id' ];
        $campaign_product->sell_price = $campaign->both_print ? $product->two_side_price : $product->one_side_price;
        $campaign_product->is_primary = true;

        $campaign->products()->save($campaign_product);

        $base_folder = 'images/campaigns/' . str_pad($campaign->id, 6, 0, STR_PAD_LEFT) . '/';
        Storage::makeDirectory($base_folder);

        if ( $data[ 'image_front' ] != '' ) {
            $file_name = $data[ 'image_front' ];
            $destination = $base_folder . $file_name;
            $original = $data[ 'base_folder' ] . $file_name;
            if ( !$this->copyFile($original, $destination) ) {
                \DB::rollback();

                return response()->json([ 'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพด้านหน้าได้' ]);
            }
            $campaign->image_front = $file_name;
        }

        if ( $data[ 'image_back' ] != '' ) {
            $file_name = $data[ 'image_back' ];
            $destination = $base_folder . $file_name;
            $original = $data[ 'base_folder' ] . $file_name;
            if ( !$this->copyFile($original, $destination) ) {
                \DB::rollback();

                return response()->json([ 'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพด้านหลังได้' ]);
            }


            $campaign->image_back = $file_name;
        }

        if ( $data[ 'thumbnail_front' ] != '' ) {
            $file_name = $data[ 'thumbnail_front' ];
            $destination = $base_folder . $file_name;
            $original = $data[ 'base_folder' ] . $file_name;
            if ( !$this->copyFile($original, $destination) ) {
                \DB::rollback();

                return response()->json([
                    'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพตัวอย่างด้านหน้าได้'
                ]);
            }
            $campaign_product->image_front = $file_name;
        }
        if ( $data[ 'thumbnail_mini_front' ] != '' ) {
            $file_name = $data[ 'thumbnail_mini_front' ];
            $destination = $base_folder . $file_name;
            $original = $data[ 'base_folder' ] . $file_name;
            if ( !$this->copyFile($original, $destination) ) {
                \DB::rollback();

                return response()->json([
                    'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพตัวอย่างด้านหน้าได้'
                ]);
            }
            $campaign_product->image_front_thmb = $file_name;
        }
        if ( $data[ 'thumbnail_back' ] != '' ) {
            $file_name = $data[ 'thumbnail_back' ];
            $destination = $base_folder . $file_name;
            $original = $data[ 'base_folder' ] . $file_name;
            if ( !$this->copyFile($original, $destination) ) {
                \DB::rollback();

                return response()->json([
                    'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพตัวอย่างด้านหลังได้'
                ]);
            }
            $campaign_product->image_back = $file_name;
        }
        if ( $data[ 'thumbnail_mini_back' ] != '' ) {
            $file_name = $data[ 'thumbnail_mini_back' ];
            $destination = $base_folder . $file_name;
            $original = $data[ 'base_folder' ] . $file_name;
            if ( !$this->copyFile($original, $destination) ) {
                \DB::rollback();

                return response()->json([
                    'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพตัวอย่างด้านหลังได้'
                ]);
            }
            $campaign_product->image_back_thmb = $file_name;
        }


        if ( !$campaign->save() ) {
            \DB::rollback();
            return response()->json([ 'success' => false, 'message' => 'ไม่สามาถบันทึกข้อมูลได้' ]);
        }

        if ( !$campaign_product->save() ) {
            \DB::rollback();
            return response()->json([ 'success' => false, 'message' => 'ไม่สามาถบันทึกข้อมูลได้' ]);
        }
        \DB::commit();

        return response()->json([
            'success'     => true,
            'campaign'    => $campaign->with('products')->where('id', $campaign->id)->first(),
            'base_folder' => $base_folder
        ]);
    }

    /**
     * Save campaign to database
     *
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function postSave ($type = 'sell')
    {
        $inputs = \Request::all();
        $url = Campaign::createUrl($inputs[ 'campaign' ][ 'title' ]);
        $end = null;

        if ( $inputs[ 'campaign' ][ 'end' ] != null ) {
            $end = Carbon::createFromFormat('d/m/Y H:i', $inputs[ 'campaign' ][ 'end' ]);
        }
        \DB::beginTransaction();
        try {
            $campaign = Campaign::create(
                [
                    'title'                => $inputs[ 'campaign' ][ 'title' ],
                    'description'          => $inputs[ 'campaign' ][ 'description' ],
                    'url'                  => $url,
                    'back_cover'           => 0,
                    'start'                => Carbon::now(),
                    'end'                  => $end,
                    'both_print'           => 0,
                    'campaign_category_id' => $inputs[ 'campaign' ][ 'campaign_category_id' ],
                    'campaign_type_id'     => CampaignType::whereName($type)->first()->id,
                    'campaign_status_id'   => CampaignStatus::whereName('check')->first()->id,
                    'user_id'              => Auth::user()->user()->id
                ]);

            if ( !$campaign ) {
                throw new \Exception('ไม่สามาถบันทึกข้อมูลได้');
            }

            if ( \Request::has('campaign.tags') ) {
                foreach ( explode(',', $inputs[ 'campaign' ][ 'tags' ]) as $tag ) {
                    $tag_data = Tag::firstOrCreate([ 'name' => $tag ]);
                    $campaign->tags()->attach($tag_data->id);
                }
            }

            $base_folder = 'images/campaigns/' . str_pad($campaign->id, 6, 0, STR_PAD_LEFT) . '/';

            Storage::makeDirectory($base_folder);

            if ( \Request::has('campaign.upload_front_art') && $inputs[ 'campaign' ][ 'upload_front_art' ] == '1' ) {
                $file_name = $inputs[ 'campaign' ][ 'upload_image_front' ][ 'file_name' ][ 'large' ];
                $destination = $base_folder . $file_name;
                $original = $inputs[ 'campaign' ][ 'upload_image_front' ][ 'path' ] . '/' . $file_name;
                if ( $this->copyFile($original, $destination) ) {
                    $campaign->image_front = $file_name;
                }
            }
            if(!$campaign->save()) {
                throw new Exception('ไม่สามารถบันทึกข้อมูลได้');
            }

            // Insert campaign_id to array for create campaign product
            $inputs[ 'campaign' ][ 'products' ][ 'campaign_id' ] = $campaign->id;
            $inputs[ 'campaign' ][ 'products' ][ 'is_primary' ] = true;

            if ( $inputs[ 'campaign' ][ 'products' ][ 'front_shirt' ] == '1' ) {
                $file_name = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'file_name' ][ 'large' ];
                $destination = $base_folder . $file_name;
                $original = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'path' ] . '/' . $file_name;
                if ( $this->copyFile($original, $destination) ) {
                    $inputs[ 'campaign' ][ 'products' ][ 'image_front' ] = $file_name;
                }
                $file_name = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'file_name' ][ 'large' ];
                $destination = $base_folder . 'small_' . $file_name;
                $original = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'path' ] . '/' . $file_name;
                if ( \ImageService::resize($original, $destination,
                    config('constant.image_size.shirt_small.max_width'),
                    config('constant.image_size.shirt_small.max_height')
                )
                ) {
                    $inputs[ 'campaign' ][ 'products' ][ 'image_front_small' ] = 'small_' . $file_name;
                }
                $file_name = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'file_name' ][ 'large' ];
                $destination = $base_folder . 'medium_' . $file_name;
                $original = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'path' ] . '/' . $file_name;
                if ( \ImageService::resize($original, $destination,
                    config('constant.image_size.shirt_medium.max_width'),
                    config('constant.image_size.shirt_medium.max_height')
                )
                ) {
                    $inputs[ 'campaign' ][ 'products' ][ 'image_front_medium' ] = 'medium_' . $file_name;
                }
                $file_name = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'file_name' ][ 'large' ];
                $destination = $base_folder . 'large_' . $file_name;
                $original = $inputs[ 'campaign' ][ 'products' ][ 'upload_image_front' ][ 'path' ] . '/' . $file_name;
                if ( \ImageService::resize($original, $destination,
                    config('constant.image_size.shirt_large.max_width'),
                    config('constant.image_size.shirt_large.max_height')
                )
                ) {
                    $inputs[ 'campaign' ][ 'products' ][ 'image_front_large' ] = 'large_' . $file_name;
                }
            }
            $product = CampaignProduct::create(array_only($inputs[ 'campaign' ][ 'products' ], [
                'campaign_id',
                'product_color_id',
                'sell_price',
                'is_primary',
                'image_front',
                'image_front_small',
                'image_front_medium',
                'image_front_large'
            ]));

            if ( !$product ) {
                throw new Exception('ไม่สามารถบันทึกข้อมูลได้');
            }

            \DB::commit();

            return response()->json([
                'result'   => true,
                'message'  => 'บันทึกแคมเปญเรียบร้อยแล้ว',
                'show_url' => action('CampaignController@showCampaign', $campaign->url),
                'edit_url' => action('AssociateController@getEditCampaign', $campaign->id)
            ]);
        } catch ( Exception $ex ) {
            \DB::rollback();
            return response()->json([ 'result' => false, 'message' => $ex->getMessage() ]);
        }

    }

    public function showCampaign ($url)
    {
        $real_url = explode('_', $url);
        $campaign = Campaign::whereUrl(head($real_url))->canShow()->first();

        if ( !$campaign ) {
            abort(404);
        }

        $selected_product = null;
        if(count($real_url) > 1) {
            $options = explode('-', last($real_url));
            $product_type = head($options);

            if(!$product_type) {
                abort(404);
            }

            $selected_product = $campaign->products()->whereHas('color', function ($query) use ($product_type) {
                $query->whereHas('product', function($query) use ($product_type) {
                    $query->where('url_slug', $product_type);
                });
            });

            $color = '';

            if(count($options) > 1) {
                $color = last($options);

                $selected_product = $selected_product->whereHas('color', function($query) use($color) {
                    $query->where('color_name', $color);
                });
            }

            $selected_product = $selected_product->first();
            if(!$selected_product) {
                abort(404);
            }
        } else {
            $selected_product = $campaign->products()->where('is_primary', true)->first();
        }
        if($campaign->status->name != 'active') {

            if ( !\Auth::user()->check()) {
                abort(404);
            }

            if($campaign->user_id != \Auth::user()->user()->id ) {
                abort(404);
            }
        }
        \Session::set('campaign_id', $campaign->id);

        $affiliate = null;

        if ( \Request::has('affid') ) {
            $affiliate = Affiliate::find(\Request::get('affid'));
        }

        $related_campaigns = $campaign->user->campaigns()->active()->where('id', '<>', $campaign->id)->get();
        
        $latest_view_campaigns = [];
        if(\Cookie::has('last_viewed')) {
            $last_vieweds = \Cookie::get('last_viewed');

            $latest_view_campaigns = Campaign::whereIn('id', $last_vieweds->pluck('id')->toArray())->get();
        }
        $comment_order = 'likes';

        if(\Request::has('comment_order')) {
            $comment_order = \Request::get('comment_order');
        }

        $comments = \CampaignService::comments($campaign->id, $comment_order);
        $comments = $comments->paginate(20);
        return view('campaign.campaign-show', [
            'title'     => $campaign->title,
            'campaign'  => $campaign,
            'affiliate' => $affiliate,
            'related_campaigns' => $related_campaigns,
            'latest_view_campaigns' => $latest_view_campaigns,
            'comments' => $comments,
            'comment_order' => $comment_order,
            'selected_product' => $selected_product
        ]);


    }

    /**
     * Copy or move file
     *
     * @param            $original
     * @param            $destination
     * @param bool|false $move
     * @return bool
     */
    function copyFile ($original, $destination, $move = false)
    {
        if ( !Storage::exists($original) ) {
            return false;
        }
        if ( $move ) {
            if ( Storage::move($original, $destination) ) {
                return true;
            }
        } else {
            if ( Storage::copy($original, $destination) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Delete  file from storage
     *
     * @param $path
     * @return bool
     */
    public function deleteFile ($path)
    {
        if ( !Storage::disk('local')->delete($path) ) {
            return false;
        }

        return true;
    }

    /**
     * Get campaign file from storage
     *
     * @param $id
     * @param $file_name
     * @return mixed
     */
    public function getFile ($id, $file_name)
    {
        $file_name_array = explode('.', $file_name);
        $ext = last($file_name_array);

        $file = Campaign::file($id, $file_name);

        $mime_type = '';

        if($ext == 'png') {
            $mime_type = 'image/png';
        } elseif($ext == 'jpg') {
            $mime_type = 'image/jpeg';
        }
        return response()->make($file, 200, array('content-type' => $mime_type));
    }

    /**
     * Remove product from campaign
     *
     * @param $product_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getRemoveProduct ($product_id)
    {
        $campaign_product = CampaignProduct::find($product_id);

        if ( !$campaign_product ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลสินค้า' ]);
        }

        if ( $campaign_product->primary ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถลบสินค้าที่ต้องเป็นสินค้าหลักได้' ]);
        }

        $campaign_product->is_deleted = true;

        if ( $campaign_product->save() ) {
            return redirect()->back()->with([ 'message' => 'ลบสินเรรียบร้อย' ]);
        }

        return redirect()->back()->withErrors([ 'ไม่สามารถลบสินค้าได้กรุณาลองใหม่' ]);
    }


    /**
     * Add product to database
     *
     * @param $campaign_id
     * @return $this
     */
    public function postAddProduct ($campaign_id)
    {
        $campaign = Campaign::whereId($campaign_id)->select([ 'id', 'both_print' ])->first();

        if ( !$campaign ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบแคมเปญ' ]);
        }
        $inputs = \Request::all();
        $product_color = ProductColor::find($inputs[ 'product' ][ 'product_color_id' ]);

        if ( !$product_color ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลสินค้าที่เลือก' ]);
        }

        $inputs[ 'product' ][ 'sell_price' ] = $campaign->both_print ? $product_color->product->two_side_price : $product_color->product->one_side_price;

        $product = new CampaignProduct();

        $product->product_color_id = $inputs[ 'product' ][ 'product_color_id' ];
        $product->sell_price = $inputs[ 'product' ][ 'sell_price' ];

        $base_folder = 'images/campaigns/' . str_pad($campaign->id, 6, 0, STR_PAD_LEFT) . '/';
        Storage::makeDirectory($base_folder);

        if ( $inputs[ 'product' ][ 'front_shirt' ] == '1' ) {
            $file_name = $inputs[ 'product' ][ 'image_front' ][ 'file_name' ][ 'large' ];
            $destination = $base_folder . $file_name;
            $original = $inputs[ 'product' ][ 'image_front' ][ 'path' ] . '/' . $file_name;

            if ( !$this->copyFile($original, $destination) ) {
                return response()->json([ 'success' => false, 'message' => 'ไม่สามารถบันทึกรูปภาพเสื้อได้' ]);
            }
            $product->image_front = $file_name;

            $file_name = $inputs[ 'product' ][ 'image_front' ][ 'file_name' ][ 'large' ];
            $destination = $base_folder . 'large_' . $file_name;
            $original = $inputs[ 'product' ][ 'image_front' ][ 'path' ] . '/' . $file_name;

            if ( \ImageService::resize($original, $destination,
                config('constant.image_size.shirt_large.max_width'),
                config('constant.image_size.shirt_large.max_height')
            )
            ) {
                $product->image_front_large = 'large_' . $file_name;
            }

            $destination = $base_folder . 'medium_' . $file_name;

            if ( \ImageService::resize($original, $destination,
                config('constant.image_size.shirt_medium.max_width'),
                config('constant.image_size.shirt_medium.max_height')
            )
            ) {
                $product->image_front_medium = 'medium_' . $file_name;
            }
            $destination = $base_folder . 'small_' . $file_name;

            if ( \ImageService::resize($original, $destination,
                config('constant.image_size.shirt_small.max_width'),
                config('constant.image_size.shirt_small.max_height')
            )
            ) {
                $product->image_front_small = 'small_' . $file_name;
            }
        }

        if ( !$campaign->products()->save($product) ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return response()->json([
            'success'      => true,
            'message'      => 'บันทึกข้อมูลสินค้าเรียบร้อย',
            'redirect_url' => action('AssociateController@getEditCampaign', $campaign->id)
        ]);
    }

    /**
     * Update campaign data
     *
     * @param $campaign_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postUpdateCampaign ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลแคมเปญ' ]);
        }
        $inputs = \Request::all();

        if ( !\Request::has('end') ) {
            $inputs[ 'end' ] = null;
        }

        if ( Campaign::where('id', $campaign_id)->update(array_only($inputs, [
            'title', 'campaign_category_id', 'description', 'end'
        ]))
        ) {
            $campaign->clearTag();
            foreach ( explode(',', $inputs[ 'tags' ]) as $tag ) {
                $tag_data = Tag::firstOrCreate([ 'name' => $tag ]);
                $campaign->tags()->attach($tag_data->id);
            }
            if ( !$campaign->updateSellPrice($inputs[ 'prices' ]) ) {
                return response()->json([ 'success' => false, 'message' => 'ไม่สมารถบันทึกข้อมูลราคาสินค้าได้' ]);
            }

            return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
        }

        return response()->json([ 'success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้' ]);
    }

    public function getData ($campaign_id)
    {
        $campaign = Campaign::with([
            'products' => function ($q) {
                $q->where('is_deleted', false);
            }
        ])->whereId($campaign_id)->first();
        $used_product = $campaign->products()->where('is_deleted', false)->get([ 'product_color_id' ])->toArray();

        return response()->json([ 'campaign' => $campaign, 'used_color' => array_flatten($used_product) ]);
    }

    public function getAvailableCampaignProduct ($campaign_id)
    {
        $products = \DB::table('campaign_products')
            ->leftJoin('product_colors', 'product_colors.id', '=', 'campaign_products.product_color_id')
            ->leftJoin('products', 'products.id', '=', 'product_colors.product_id')
            ->where('is_deleted', false)
            ->where('campaign_id', $campaign_id)
            ->orderBy('product_id')
            ->get([
                'product_id',
                'name',
                'campaign_products.id as campaign_product_id',
                'url_slug',
                'product_color_id',
                'color',
                'color_name',
                'campaign_products.image_front',
                'campaign_products.image_back',
                'sell_price',
                'is_primary',
                'size_chart'
            ]);
        return response()->json($products);
    }

    public function getAvailableSku ($campaign_id)
    {
        $campaign_product = Campaign::with([
            'products'                                => function ($q) {
                $q->where('is_deleted', false);
            }, 'products.color', 'products.color.sku' => function ($q) {
                $q->where('is_active', true);
            }
        ])->where('id', $campaign_id)->first();

        return response()->json($campaign_product);
    }

    /**
     * Set campaign close status
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getClose ($id)
    {
        $campaign = Campaign::find($id);

        if ( !$campaign ) {
            return redirect()->back()->withErrors([ 'ไม่พบแคมเปญที่ต้องการ' ]);
        }

        if ( !\CampaignService::close($campaign->id) ) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
        return response()->json(['success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย']);
    }

    /**
     * Set campaign open status
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getOpen ($id)
    {
        $campaign = Campaign::find($id);

        if ( !$campaign ) {
            return redirect()->back()->withErrors([ 'ไม่พบแคมเปญที่ต้องการ' ]);
        }

        if ( !\CampaignService::open($campaign->id) ) {
            return response()->json(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
        return response()->json(['success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย']);
    }

    /**
     * Set campaign product primary
     *
     * @param $campaign_product_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postSetPrimary ($campaign_product_id)
    {
        $campaign_product = CampaignProduct::find($campaign_product_id);

        if ( !$campaign_product ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลสินค้า' ]);
        }

        $campaign_product->is_primary = true;

        if ( $campaign_product->setPrimary() ) {
            return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลแล้ว' ]);
        }

        return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลสินค้า' ]);
    }

    /**
     * Add user wish list campaign
     *
     * @param $campaign_id
     * @param $user_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAddToWishList ($campaign_id, $user_id)
    {
        $campaign_wish_list = CampaignWishList::where('campaign_id', $campaign_id)->where('user_id', $user_id)->first();

        if ( $campaign_wish_list ) {
            $campaign_wish_list->delete();
            return response()->json([ 'success' => true, 'message' => 'removed', 'is_wished' => 0 ]);
        } else {
            CampaignWishList::create([
                'campaign_id' => $campaign_id,
                'user_id'     => $user_id
            ]);
        }
        return response()->json([ 'success' => true, 'message' => 'added', 'is_wished' => 1 ]);
    }


    public function postSaveComment ()
    {
        $inputs = \Request::all();

        $comment = Comment::create([
            'campaign_id' => $inputs[ 'campaign_id' ],
            'user_id'     => $inputs[ 'user_id' ],
            'message'     => htmlentities($inputs[ 'message' ]),
        ]);

        if ( $comment ) {
            return response()->json([
                'success'   => true,
                'message'   => 'บันทึกข้อความเรียบร้อยแล้ว',
                'full_name' => $comment->user->full_name,
                'avatar'    => $comment->user->avatar,
                'comment'   => $comment
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'ไม่สามารถบันทึกข้อความได้'
        ]);
    }

    public function getSearch ($category = 'all')
    {
        $keyword = '';
        $selected_category = CampaignCategory::whereName($category)->first();
        if ( \Request::has('q') ) {
            $keyword = \Request::get('q');
        }

        return view('search', [
            'title'    => 'ผลการค้นหา ' . $keyword,
            'keyword'  => $keyword,
            'selected_category' => $selected_category
        ]);
    }

    public function postSurprise ()
    {
        $inputs = \Request::all();

        $campaign = CampaignProduct::surprise($inputs[ 'category_id' ], $inputs[ 'product_id' ], $inputs[ 'color' ]);

        if ( !$campaign ) {
            return response()->json([
                'success' => false,
                'result'  => null
            ]);
        }

        $results = [
            'id'    => $campaign->id,
            'name'  => $campaign->title,
            'price' => $campaign->primaryPrice(),
            'url'   => action('CampaignController@showCampaign')
        ];


        return response()->json([
            'success' => true,
            'result'  => $results
        ]);
    }
}
