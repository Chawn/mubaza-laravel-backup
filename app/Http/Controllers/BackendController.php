<?php namespace App\Http\Controllers;
;
use App\Admin;
use App\AdminRole;
use App\AdminStatus;
use App\Affiliate;
use App\CampaignStatus;
use App\Cost;
use App\Http\Requests;
use App\Category;
use App\CampaignCategory;
use App\Campaign;
use App\Http\Requests\AdminFormRequest;
use App\Lib\Ggseven\Listeners\AdminListenerInterface;
use App\Lib\Ggseven\Listeners\AssociateListenerInterface;
use App\Lib\Ggseven\OrderListenerInterface;
use App\Lib\Ggseven\UserListenerInterface;
use App\MonthlyCommission;
use App\NotificationType;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\Payment;
use App\PaymentStatus;
use App\Payout;
use App\PayoutStatus;
use App\PayoutType;
use App\Product;
use App\ProductDescription;
use App\ProductColor;
use App\ProductOutline;
use App\ProductSku;
use App\User;
use Chumper\Zipper\Zipper;
use CommissionService;
use Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BackendController extends Controller implements OrderListenerInterface,
    UserListenerInterface,
    AdminListenerInterface,
    AssociateListenerInterface
{
    public function __construct ()
    {
        $this->middleware('admin.auth', [
            'except' => [
                'getLogin',
                'postLogin'
            ]
        ]);
    }

    /**
     * Backend index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex ()
    {
        $checking_campaigns = \CampaignService::checking()->paginate(8);

        return view('backend.index', [
            'title'              => 'Admin Dashboard',
            'checking_campaigns' => $checking_campaigns,
        ]);
    }


    public function getStatistic ()
    {
        $user_count = User::countAll();
        $user_count_year = User::countAll(\Carbon::now()->subYear(), \Carbon::now());
        $user_count_day = User::countAll(\Carbon::now()->subDay(), \Carbon::now());
        $user_count_week = User::countAll(\Carbon::now()->subWeek(), \Carbon::now());
        $user_count_month = User::countAll(\Carbon::now()->subMonth(), \Carbon::now());
        $campaign_count = Campaign::countAll();
        $campaign_count_year = Campaign::countAll(\Carbon::now()->subYear(), \Carbon::now());
        $campaign_count_day = Campaign::countAll(\Carbon::now()->subDay(), \Carbon::now());
        $campaign_count_week = Campaign::countAll(\Carbon::now()->subWeek(), \Carbon::now());
        $campaign_count_month = Campaign::countAll(\Carbon::now()->subMonth(), \Carbon::now());
        $order_count = Order::countAll();
        $order_count_day = Order::countAll(\Carbon::now()->subDay(), \Carbon::now());
        $order_count_week = Order::countAll(\Carbon::now()->subWeek(), \Carbon::now());
        $order_count_month = Order::countAll(\Carbon::now()->subMonth(), \Carbon::now());
        $order_count_year = Order::countAll(\Carbon::now()->subYear(), \Carbon::now());
        $item_count = Order::countQTYAll();
        $item_count_day = Order::countQTYAll(\Carbon::now()->subDay(), \Carbon::now());
        $item_count_week = Order::countQTYAll(\Carbon::now()->subWeek(), \Carbon::now());
        $item_count_month = Order::countQTYAll(\Carbon::now()->subMonth(), \Carbon::now());
        $item_count_year = Order::countQTYAll(\Carbon::now()->subYear(), \Carbon::now());
        return view('backend.statistic', [
            'title'                => 'สถิติการใช้งานเว็บไซต์',
            'user_count'           => $user_count->user_count,
            'user_count_day'       => $user_count_day->user_count,
            'user_count_week'      => $user_count_week->user_count,
            'user_count_month'     => $user_count_month->user_count,
            'user_count_year'      => $user_count_year->user_count,
            'campaign_count'       => $campaign_count->campaign_count,
            'campaign_count_day'   => $campaign_count_day->campaign_count,
            'campaign_count_week'  => $campaign_count_week->campaign_count,
            'campaign_count_month' => $campaign_count_month->campaign_count,
            'campaign_count_year'  => $campaign_count_year->campaign_count,
            'order_count'          => $order_count->order_count,
            'order_count_day'      => $order_count_day->order_count,
            'order_count_week'     => $order_count_week->order_count,
            'order_count_month'    => $order_count_month->order_count,
            'order_count_year'     => $order_count_year->order_count,
            'item_count'           => $item_count->total_order,
            'item_count_day'       => $item_count_day->total_order,
            'item_count_week'      => $item_count_week->total_order,
            'item_count_month'     => $item_count_month->total_order,
            'item_count_year'      => $item_count_year->total_order,
        ]);
    }

    public function getLogin ()
    {
        return view('backend.backend-login', [ 'title' => 'เข้าสู่ระบบ' ]);
    }

    public function postLogin ()
    {
        $request = Request::all();
        if ( \Auth::admin()->attempt([ 'email' => $request[ 'email' ], 'password' => $request[ 'password' ] ]) ) {
            return redirect(action('BackendController@getIndex'));
        } else {
            \Log::warning('Login failed From IP : ' . Request::getClientIp());
        }

        return redirect('backend/login')->withErrors([
            'email' => 'อีเมล์ และรหัสผ่าน ไม่ตรงกัน',
        ]);
    }

    public function getLogout ()
    {
        if ( \Auth::admin()->check() ) {
            \Auth::admin()->logout();
        }

        return redirect('backend/login');
    }

    public function getStock ()
    {
        $categories = Category::all();

        return view('backend.stock.index', [
            'title'      => 'สินค้าคงคลัง',
            'categories' => $categories,
        ]);
    }

    public function getPurchase ()
    {
        $categories = Category::all();

        return view('backend.purchase.index', [
            'title'      => 'รายการจัดซื้อ',
            'categories' => $categories,
        ]);
    }

    public function getProduct ()
    {
        $products = Product::all();
        $categories = Category::all();

        return view('backend.products.index', [
            'title'      => 'รายการสินค้าทั้งหมด',
            'products'   => $products,
            'categories' => $categories,
        ]);
    }


    public function getDeleteProduct ($id)
    {
        $product = Product::find($id);

        if ( !is_null($product) ) {
            $product->delete();

            return redirect()->action('BackendController@getProduct');
        }

        return FALSE;
    }

    public function getCategory ()
    {
        $categories = Category::paginate(10);

        return view('backend.category.index', [
            'title'      => 'รายการหมวดหมู่สินค้า',
            'categories' => $categories
        ]);

    }

    public function getAddCategory ()
    {
        return view('backend.category.add', [
            'title' => 'เพิ่มหมวดหมู่สินค้า'
        ]);
    }

    public function getEditCategory ($id)
    {
        $category = Category::find($id);

        return view('backend.category.edit', [
            'title'        => 'แก้ไขหมวดหมู่สินค้า',
            'category'     => $category,
            'parent_pages' => [
                'url'   => action('BackendController@getCategroy'),
                'title' => 'หมวดหมู่ทั้งหมด'
            ]
        ]);
    }

    public function getDeleteCategory ($id)
    {
        Category::destroy($id);

        return redirect()->action('BackendController@getCategory');
    }

    public function postSaveCategory ()
    {
        $inputs = Request::all();
        $category = Category::create([
            'name'   => $inputs[ 'name' ],
            'detail' => $inputs[ 'detail' ]
        ]);

        return redirect()->action('BackendController@getCategory');
    }

    public function postUpdateCategory ()
    {
        $inputs = Request::all();
        $category = Category::find($inputs[ 'id' ])->update([
            'name'   => $inputs[ 'name' ],
            'detail' => $inputs[ 'detail' ]
        ]);

        return redirect()->action('BackendController@getCategory');
    }

    public function getBrand ()
    {
        $brands = BrandModel::paginate(15);

        return view('backend.brand.index', [
            'title'  => 'รายการยี่ห้อสินค้า',
            'brands' => $brands
        ]);

    }

    public function getAddBrand ()
    {
        return view('backend.brand.add', [
            'title' => 'เพิ่มยี่ห้อสินค้า'
        ]);
    }

    public function getEditBrand ($id)
    {
        $brand = BrandModel::find($id);

        return view('backend.brand.edit', [
            'title' => 'แก้ไขยี่ห้อสินค้า',
            'brand' => $brand
        ]);
    }

    public function getDeleteBrand ($id)
    {
        BrandModel::destroy($id);

        return redirect()->action('BackendController@getBrand');
    }

    public function postSaveBrand ()
    {
        $inputs = Request::all();
        $brand = BrandModel::create([
            'name'   => $inputs[ 'name' ],
            'detail' => $inputs[ 'detail' ]
        ]);

        return redirect()->action('BackendController@getBrand');
    }

    public function postUpdateBrand ()
    {
        $inputs = Request::all();
        $brand = BrandModel::find($inputs[ 'id' ])->update([
            'name'   => $inputs[ 'name' ],
            'detail' => $inputs[ 'detail' ]
        ]);

        return redirect()->action('BackendController@getBrand');
    }

    public function getProductType ()
    {
        $product_types = ProductTypeModel::all();

        return view('backend.product_type.index', [
            'title'         => 'รายการประเภทสินค้า',
            'product_types' => $product_types
        ]);

    }

    public function getProductOutline ()
    {
        $products = Product::all();

        return view('backend.product_outline.index', [
            'title'    => 'รายการพื้นที่การออกแบบ',
            'products' => $products
        ]);
    }

    public function getAddProductOutline ($id)
    {
        $product = Product::find($id);

        if ( !$product ) {
            return 'Product not found';
        }

        return view('backend.product_outline.add', [
            'title'   => 'เพิ่มพื้นที่การออกแบบ',
            'product' => $product
        ]);
    }

    public function postSaveProductOutline ()
    {
        $inputs = Request::all();
        $product_outline = ProductOutline::find($inputs[ 'product_id' ]);

        if ( $product_outline ) {
            $product_outline->update(array_except($inputs, '_token'));
        } else {
            ProductOutline::create(array_except($inputs, '_token'));
        }

        return response()->json([ 'result' => 'success', 'url' => action('BackendController@getProductOutline') ]);
    }

    /*
     * Campaign
     */

//    public function getCampaign($status_name = '')
//    {
//        if (\Request::has('q')) {
//            $q = \Request::get('q');
//            $campaigns = Campaign::orderBy('created_at', 'desc')
//                ->whereHas('user', function ($query) use ($q) {
//                    $query->where('users.full_name', $q);
//                })
//                ->orWhere('id', 'like', '%' . $q . '%')
//                ->orWhere('title', 'like', '%' . $q . '%')
//                ->paginate(20);
//            // dd($campaigns);
//        } else {
//
//            if ($status_name != '') {
//                $campaigns = Campaign::orderBy('created_at', 'desc')
//                    ->where('campaign_status_id', \App\CampaignStatus::whereName($status_name)->first()->id)
//                    ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)->paginate(20);
//            } else {
//                $campaigns = Campaign::orderBy('created_at', 'desc')
//                    ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)->paginate(20);
//            }
//        }
//
//
//        return view('backend.campaign.index', [
//            'title' => 'แคมเปญ',
//            'campaigns' => $campaigns,
//            'status_name' => $status_name
//        ]);
//    }

    public function getEditCampaign ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        return view('backend.campaign.edit', [
            'title'    => 'แก้ไขรายละเอียดแคมเปญ : ' . $campaign->title . ' #' . $campaign->id,
            'campaign' => $campaign
        ]);
    }

    public function postUpdateCampaign ()
    {
        $inputs = Request::all();
        $campaign = \App\Campaign::find($inputs[ 'campaign_id' ]);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        if ( $campaign->type->name == 'sell' && !\App\Campaign::checkUrl($inputs[ 'url' ], $campaign->url) ) {
            return 'Url ไม่ว่าง';
        }

        $campaign->update(array_except($inputs, [ 'block_front_count', 'block_back_count', '_token' ]));

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
    }

    public function getCampaignDetail ($campaign_id)
    {
        $campaign = Campaign::where('id', $campaign_id)->first();
        $campaign_statuses = \App\CampaignStatus::all();

        $categories = CampaignCategory::where('is_active', true)->get([ 'id', 'name' ]);

        /*
        if ( $campaign ) {
            $orders = $this->orderedProductById($campaign_id);
            $campaign_statuses = \App\CampaignStatus::all();

            return view('backend.campaign.campaign-detail', [
                'title'             => $campaign->title,
                'campaign'          => $campaign,
                'orders'            => $orders,
                'campaign_statuses' => $campaign_statuses,
                'parent_pages'      => [
                    'url'   => action('BackendController@getCampaign'),
                    'title' => 'แคมเปญ'
                ]
            ]);
        }

        return 'Campaign Not Found';
        */

        return view('backend.campaign.campaign-detail', [
            'title'             => $campaign->title,
            'campaign'          => $campaign,
            'campaign_statuses' => $campaign_statuses,
            'categories'        => $categories,
            'parent_pages'      => [
                'url'   => action('BackendController@getCampaign'),
                'title' => 'แคมเปญ'
            ]
        ]);
    }

    public function postBanCampaign ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            abort(404);
        }
        $campaign->status()->associate(\App\CampaignStatus::whereName('ban')->first());
        $campaign->remark = Request::has('remark') ? Request::get('remark') : '';
        if ( !$campaign->save() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->action('BackendController@getCampaign')->with('message', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function getActivateCampaign ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            abort(404);
        }

        $campaign->status()->associate(CampaignStatus::active()->first());
        $campaign->remark = '';

        if ( !$campaign->save() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->back()->with('messsage', 'เปิดการใช้งานแคมเปญแล้ว');
    }

    public function getSetActiveCampaign ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return view('errors.campaign-not-found', [ 'title' => 'Campaign Not Found' ]);
        }
        if ( $campaign->end < \Carbon::now() ) {
            $campaign->campaign_status_id = \App\CampaignStatus::whereName('close')->first()->id;
        } else {
            $campaign->campaign_status_id = \App\CampaignStatus::whereName('running')->first()->id;
        }

        if ( $campaign->update() ) {
            return redirect()->action('BackendController@getCampaign')->with('message', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        }

        return 'การบันทึกข้อมูลผิดพลาด';

    }

    public function sendEmailCampaignBanned ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        $user = $campaign->user;
        \Mail::queue('backend.mail.campaign-banned', [
            'campaign' => $campaign,
            'user'     => $user,
            'base_url' => url('/') . '/'
        ], function ($m) use ($user) {
            $m->to($user->email, $user->full_name)->subject('แคมเปญที่คุณสร้างถูกระงับการสร้างรายได้');
        });
    }

    /*
     * End campaign
     */

    public function getSale ()
    {
        $campaigns = Campaign::orderBy('end')->get();

        return view('backend.sale.index', [
            'title'     => 'การขาย',
            'campaigns' => $campaigns
        ]);
    }

    /*
     * Produce section in backend
     */
    public function getProduce ()
    {
        $campaigns = Campaign::orderBy('end', 'desc')
            ->whereIn('campaign_produce_status_id', [ '2', '3' ])
            ->where('end', '<', \Carbon::now())
            ->orWhere('campaign_type_id', \App\CampaignType::whereName('buy')->first()->id)->paginate(15);

        $campaigns->setPageName('produce');

        // Select campaign if produce status is waiting
        $ended_campaigns = Campaign::orderBy('end', 'desc')
            ->where('campaign_produce_status_id', CampaignProduceStatus::whereName('waiting')->first()->id)
            ->where('end', '<', \Carbon::now())->paginate(15);

        $ended_campaigns->setPageName('ended_campaign');

        return view('backend.manufacture.index', [
            'title'           => 'การผลิต',
            'campaigns'       => $campaigns,
            'ended_campaigns' => $ended_campaigns
        ]);
    }


    /**
     * Show all campaign ready to approve
     *
     * @return \Illuminate\View\View
     */
    public function getApproveToProduce ()
    {
        Campaign::clearNoOrder();
        $campaigns = Campaign::allApprove(20);

        $latest_updates = Campaign::GetCampaign(null, [
            CampaignProduceStatus::whereName('waiting')->first()->id,
            CampaignProduceStatus::whereName('cancel')->first()->id
        ], false, 'sell', 'updated_at', 'desc');
//        $latest_updates = \App\Campaign::orderBy('updated_at', 'desc')
//            ->whereIn('campaign_produce_status_id', [
//                \App\CampaignProduceStatus::whereName('waiting')->first()->id,
//                \App\CampaignProduceStatus::whereName('cancel')->first()->id
//            ])->take(10)->get();

        return view('backend.manufacture.index-approve', [
            'title'          => 'ตรวจสอบการผลิต',
            'campaigns'      => $campaigns,
            'latest_updates' => $latest_updates->take(10)->get()
        ]);

    }

    /**
     * Show ready to approve campaign page
     *
     * @param $campaign_id
     * @return \Illuminate\View\View|string
     */
    public function getShowApprove ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign Not Found';
        }

        $transfer_orders = Order::where('campaign_id', $campaign->id)
            ->where('payment_type_id', \App\PaymentType::whereName('transfer')->first()->id)
            ->get();

        $card_orders = Order::where('campaign_id', $campaign->id)
            ->where('payment_type_id', \App\PaymentType::whereName('card')->first()->id)
            ->get();

        return view('backend.manufacture.show-approve', [
            'title'           => 'ตรวจสอบการผลิตแคมเปญ ' . $campaign->title,
            'campaign'        => $campaign,
            'transfer_orders' => $transfer_orders,
            'card_orders'     => $card_orders
        ]);
    }

    public function postUpdateBlockCount ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        $inputs = Request::all();

        $design = $campaign->design;

        if ( !$design ) {
            return 'Campaign has problem please contact admin';
        }

        if ( Request::has('block_front_count') ) {
            $design->block_front_count = $inputs[ 'block_front_count' ];
        }
        if ( Request::has('block_back_count') ) {
            $design->block_back_count = $inputs[ 'block_back_count' ];
        }

        if ( $design->update() ) {
            $campaign->block_cost = (config('constant.block_unit_cost') * ($design->block_front_count + $design->block_back_count)) + config('constant.block_base_cost');
            $campaign->update();
            return response()->json([ 'error' => false, 'message' => 'บันทึกจำนวนบล็อกเรียบร้อยแล้ว' ]);
        }
        return response()->json([ 'error' => true, 'message' => 'เกิดผิดพลาดในการบันทึกจำนวนบล็อก' ]);

    }

    /**
     * Close campaign
     *
     * @param $campaign_id
     * @return $this|\Illuminate\Http\RedirectResponse|string
     */
    public function getCloseCampaign ($campaign_id)
    {
        $campaign = Campaign::with([
            'orders' => function ($query) {
                $query->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id);
            }
        ])->where('id', $campaign_id)->first();

        if ( !$campaign ) {
            return 'Campaign Not Found';
        }

        if ( $campaign->isRunning() ) {
            return redirect()->back()->withErrors([ 'แคมเปญนี้ทำงานอยู่ไม่สามารถปิดได้' ]);
        }


        $campaign->campaign_status_id = \App\CampaignStatus::whereName('cancel')->first()->id;
        $campaign->campaign_produce_status_id = CampaignProduceStatus::whereName('cancel')->first()->id;
        if ( $campaign->save() ) {
            $this->sendEmailNotProduce($campaign);
            $this->sendEmailNotProduceToCreator($campaign->id);
            return redirect()->action('BackendController@getApproveToProduce', $campaign->id)->with('message', 'ปิดแคมเปญแล้ว');
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);

    }

    function sendEmailNotProduce ($campaign)
    {
        // TODO: Need beanstalkd server for queue email message send
        $orders = $campaign->orders;
        foreach ( $orders as $order ) {
            \Mail::queue('backend.mail.notproduce', [
                'campaign' => $campaign,
                'order'    => $order,
                'user'     => $order->user,
                'base_url' => url('/') . '/'
            ], function ($m) use ($order) {
                $m->to($order->user->email, $order->user->full_name)->subject('แคมเปญที่คุณสั่งซื้อไม่ได้รับการผลิต');
            });
        }
    }

    function sendEmailNotProduceToCreator ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        $user = $campaign->user;
        \Mail::queue('backend.mail.campaign-nonproduce', [
            'campaign' => $campaign,
            'user'     => $user,
            'base_url' => url('/') . '/'
        ], function ($m) use ($user) {
            $m->to($user->email, $user->full_name)->subject('แคมเปญที่คุณสร้างไม่ได้รับการผลิต');
        });
    }

    /**
     * Set campaign for ready to produce and
     *
     * @param $campaign_id
     * @return $this|\Illuminate\Http\RedirectResponse|string
     */
    public function getSetWaitingCampaign ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign Not Found';
        }

        $campaign->produce_status()->associate(CampaignProduceStatus::whereName('waiting')->first());
        $campaign->status()->associate(\App\CampaignStatus::whereName('close')->first());
        $campaign->is_checked = 1;
        if ( $campaign->save() ) {
            $this->sendEmailReadyToProduce($campaign->id);
            $this->sendEmailEarning($campaign->id);
            return redirect()->action('BackendController@getShowApprove', $campaign->id)->with('message', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);

    }

    /**
     * Set campaign status and charge credit card
     *
     * @param $campaign_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getSetToProduce ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return redirect()->back()->withErrors('ไม่พบแคมเปญนี้');
        }

        $campaign->status()->associate(\App\CampaignStatus::whereName('close')->first());
        $campaign->produce_status()->associate(CampaignProduceStatus::whereName('producing')->first());
        $campaign->produce_start = \Carbon::now();
        if ( !$campaign->save() ) {
            return redirect()->back()->withErrors('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        }

        return redirect()->action('BackendController@getShowProduce', $campaign_id);
    }

    function sendEmailReadyToProduce ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        // TODO:Increase PHP Execution Time may be longer
        $orders = Order::where('campaign_id', $campaign_id)
            ->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id)
            ->get();
        foreach ( $orders as $order ) {
            \Mail::queue('backend.mail.produce', [
                'campaign'   => $campaign,
                'order'      => $order,
                'user'       => $order->user,
                'close_date' => $campaign->end->format('d m Y'),
                'base_url'   => url('/') . '/'
            ], function ($m) use ($order) {
                $m->to($order->user->email, $order->user->full_name)->subject('แคมเปญที่คุณสั่งซื้อได้เริ่มทำการผลิตแล้ว');
            });
        }
    }

    function sendEmailEarning ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        \Mail::queue('backend.mail.produce-earnings', [
            'campaign'     => $campaign,
            'user'         => $campaign->user,
            'id'           => $campaign->user->getID(),
            'total_order'  => $campaign->totalOrder(),
            'total_profit' => $campaign->totalProfit()
        ], function ($m) use ($campaign) {
            $m->to($campaign->user->email, $campaign->user->full_name)->subject('แคมเปญที่คุณสั่งซื้อได้เริ่มทำการผลิตแล้ว');
        });
    }

    /**
     * Charge money from credit card from stored in Omise
     *
     * @param $order_id
     * @return array
     */
    public function getChargeCard ($order_id)
    {
        define('OMISE_PUBLIC_KEY', env('OMISE_PUBLIC_KEY'));
        define('OMISE_SECRET_KEY', env('OMISE_SECRET_KEY'));

        $order = Order::with('payment')->where('id', $order_id)
            ->where('payment_type_id', \App\PaymentType::whereName('card')->first()->id)
            ->where('payment_status_id', PaymentStatus::whereName('paid_by_card')->first()->id)
            ->first();
        if ( !$order ) {
            return [ 'error' => false, 'success' => false, 'message' => 'ไม่พบรายการสั่งซื้อ' ];
        }

        if ( $order->payment->first()->transaction_id == '' ) {
            return [ 'error' => false, 'success' => false, 'message' => 'ไม่พบรหัสการตัดบัตรเครดิตหรือเดบิต' ];
        }
        if ( !$order->campaign->is_checked ) {
            $campaign = $order->campaign;
            $campaign->is_checked = true;
            $campaign->save();
        }

        $payment = $order->payment[ 0 ];
        $sub_total = $order->subTotal();

        try {
            $card = \OmiseCharge::create([
                'amount'      => number_format($sub_total, 2, '', ''),
                'currency'    => 'thb',
                'description' => 'Order-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'return_uri'  => action('OrderController@getComplete', $order->id),
                'customer'    => $order->payment->first()->transaction_id
            ]);
        } catch ( \Exception $ex ) {
            $payment->remark = $ex->getMessage();
            $payment->save();
            return response()->json([ 'error' => false, 'success' => false, 'message' => $ex->getMessage() ]);
        }

        if ( !$card[ 'failure_code' ] ) {
            // Update payment info

            $payment->total = $sub_total;
            $payment->pay_on = date('Y-m-d h:m:s');
            $payment->transaction_id = $card[ 'transaction' ];
            $payment->from_bank = $card[ 'card' ][ 'brand' ];
            $payment->to_bank = 'Card';
            $payment->order_id = $order->id;
            $payment->is_charged = true;
            $payment->save();
            // Update payment_status_id to paid

            $order->payment_status()->associate(PaymentStatus::whereName('paid')->first());
            $order->save();

            return response()->json([ 'error' => false, 'success' => true ]);
        }

        return response()->json([ 'error' => false, 'success' => false ]);

    }


    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getShowProduce ($id)
    {
        // TODO: if has error about "Maximum function nesting level of '100' reached, aborting!" set xdebug.max_nesting_level=500
        $campaign = Campaign::find($id);

        if ( !$campaign ) {
            return redirect()->back()->withErrors('ไม่พบแคมเปญนี้');
        }


        $ordered_product = $this->orderedProductById($id, true);
        $orders = $campaign->orders()->simplePaginate(20);

        return view('backend.manufacture.produce-detail', [
            'title'           => 'รายละเอียดการผลิต ' . $campaign->title,
            'campaign'        => $campaign,
            'orders'          => $orders,
            'ordered_product' => $ordered_product
        ]);
    }

    public function orderedProductById ($id, $paid_only = false)
    {
        $orders = Order::where('campaign_id', $id)
            ->with('allItems', 'allItems.item', 'allItems.item.product_image', 'allItems.item.product');

        if ( $paid_only ) {
            $orders = $orders->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id);
        } else {
            $orders = $orders->whereIn('payment_status_id', [
                PaymentStatus::whereName('paid')->first()->id,
                PaymentStatus::whereName('paid_by_card')->first()->id
            ]);
        }

        $orders = $orders->get();
        $items = [ ];
        $data = [ ];
        $total = 0;
        foreach ( $orders as $index => $order ) {
            foreach ( $order->allItems as $key => $item ) {
                if ( isset($items[ $item->item->product_id ][ 'colors' ][ $item->item->product_image->color_name ][ 'sizes' ][ $item->size ]) ) {
                    $items[ $item->item->product_id ][ 'colors' ][ $item->item->product_image->color_name ][ 'sizes' ][ $item->size ] += $item->qty;
                    $items[ $item->item->product_id ][ 'total' ] += $item->qty;
                    $total += $item->qty;
                } else {
                    $items[ $item->item->product_id ][ 'name' ] = $item->item->product->name;
                    $items[ $item->item->product_id ][ 'available_size' ] = $item->item->product->available_size;
                    $items[ $item->item->product_id ][ 'sell_price' ] = $item->item->sell_price;
                    isset($items[ $item->item->product_id ][ 'total' ]) ? $items[ $item->item->product_id ][ 'total' ] += $item->qty : $items[ $item->item->product_id ][ 'total' ] = $item->qty;
                    $items[ $item->item->product_id ][ 'colors' ][ $item->item->product_image->color_name ][ 'sizes' ][ $item->size ] = $item->qty;
                    $total += $item->qty;
                }
            }
        }

        $data[ 'total' ] = $total;
        $data[ 'items' ] = $items;
        return $data;
    }

    public function getPrintCheckListReport ($id)
    {
        $campaign = Campaign::where('id', $id)
            ->with('orders', 'orders.allItems', 'orders.allItems.item', 'orders.allItems.item.product_image')
            ->whereHas('orders', function ($q) {
                $q->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id);
            })
            ->get()->first();

        return view('backend.manufacture.check-list-report', [ 'campaign' => $campaign ]);
    }

    public function getPrintProduceList ($id)
    {
        $campaign = Campaign::find($id);
        $ordered_product = $this->orderedProductById($id, true);
        return view('backend.manufacture.produce-list', [
            'title'           => 'ใบรายการผลิต แคมเปญ ' . $campaign->title,
            'campaign'        => $campaign,
            'ordered_product' => $ordered_product
        ]);
    }

    /*
     * Transport section
     */
    /* public function getTransport()
     {
         $campaigns = Campaign::orderBy('end', 'desc')
             ->where('campaign_produce_status_id', CampaignProduceStatus::whereName('shipped')->first()->id)
             ->where('campaign_status_id', \App\CampaignStatus::whereName('close')->first()->id)
             ->paginate(15);
 //        $campaigns = Campaign::GetCampaign(
 //            \App\CampaignStatus::whereName('close')->first()->id,
 //            \App\CampaignProduceStatus::whereName('shipped')->first()->id,
 //            false, '', 'end', 'desc'
 //        );
 //        dd($campaigns);
         return view('backend.transport.index', [
             'title' => 'การจัดส่ง',
             'campaigns' => $campaigns
         ]);
     }*/

    /*public function getWaitingTransport()
    {
        $campaigns = Campaign::orderBy('end', 'desc')
            ->where('campaign_produce_status_id', CampaignProduceStatus::whereName('shipping')->first()->id)
            ->where('campaign_status_id', \App\CampaignStatus::whereName('close')->first()->id)
            ->paginate(15);

        return view('backend.transport.wait', [
            'title' => 'รอการจัดส่งสินค้า',
            'campaigns' => $campaigns
        ]);
    }*/

    public function getShowTransport ($id)
    {
        // TODO: if has error about "Maximum function nesting level of '100' reached, aborting!" set xdebug.max_nesting_level=500
        $campaign = Campaign::with('orders')->whereHas('orders', function ($q) {
            $q->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id);
        })
            ->where('id', $id)->first();
        $ordered_product = $this->orderedProductById($id);
        $orders = $campaign->orders()->simplePaginate(20);

        return view('backend.transport.detail', [
            'title'           => 'รายละเอียดการจัดส่งสินค้า',
            'campaign'        => $campaign,
            'ordered_product' => $ordered_product,
            'orders'          => $orders
        ]);
    }

    public function getSetTransported ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( $campaign && $campaign->produce_status->name == 'shipping' ) {
            $campaign->produce_status()->associate(CampaignProduceStatus::whereName('shipped')->first());
            if ( $campaign->save() ) {
                $this->sendEmailTransported($campaign_id);
                return redirect()->action('BackendController@getTransport')->with('message', 'บันทึกสถานะการจัดส่งเสร็จเรียบร้อย');
            }

            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);
        }

        return 'Campaign not found';
    }

    function sendEmailTransported ($campaign_id)
    {
        $campaign = Campaign::where('id', $campaign_id)
            ->where('campaign_produce_status_id', CampaignProduceStatus::whereName('shipped')->first()->id)
            ->whereHas('orders', function ($query) {
                $query->where('payment_status_id', PaymentStatus::whereName('paid')->first()->id);
            })->first();

        $orders = $campaign->orders;
        foreach ( $orders as $key => $order ) {
            \Mail::queue('backend.mail.shipping', [
                'order_id'    => $order->id,
                'user'        => $order->user,
                'campaign'    => $campaign,
                'tracking_no' => (is_null($order->shipping_address)) ? 'tracking goes here' : $order->shipping_address->tracking_no,
                'base_url'    => url('/') . '/'
            ], function ($m) use ($order) {
                $m->to($order->user->email, $order->user->full_name)->subject('สินค้าที่คุณสั่งซื้อได้ทำการจัดส่งแล้ว');
            });
        }

    }

    public function postSaveTrackingNO ($shipping_address_id)
    {
        $inputs = Request::all();
        $shipping_address = \App\ShippingAddress::find($shipping_address_id);
        $shipping_address->tracking_no = $inputs[ 'tracking_no' ];;

        if ( $shipping_address->update() ) {
            return response()->json([ 'result' => true, 'message' => 'บันทึกเสร็จเรียบร้อย' ]);
        }

        return response()->json([ 'result' => false, 'message' => 'เกิดข้อผิดพลาดในการบันทึก' ]);
    }

    /*
     * End transport section
     */
    public function getScreenSVG ($id, $location)
    {
        $item_texts = CampaignText::where('campaign_id', $id)
            ->where('lacation', $location)
            ->orderBy('z_index', 'asc')
            ->get();
        //เพิ่ม where location = front และ back Order by z-index asc แล้ววนลูปสองรอบ

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="206" height="403" version="1.2">';
        foreach ( $item_texts as $item ) {
            $text = $item->text;
            $color = $item->color;
            $family = $item->family;
            $size = $item->size;
            $left = $item->left;
            $top = $item->top;
            $rotate = $item->rotate * (180 / pi());

            $svg = $svg . '<text x="0" y="0" font-family="' . $family . '" fill="' . $color . '" transform="translate(' . $left . ', ' . $top . ') rotate(' . $rotate . ')" font-size="' . $size . '">' . $text . '
                        </text>';
        }
        $svg = $svg . "</svg>";

        return $svg;
    }

    /* User backend */
    /**
     * Get all user in database
     *
     * @return \Illuminate\View\View
     */
    public function getUsers ($paging = 12)
    {
        $keyword = '';

        if ( Request::has('q') ) {
            $keyword = Request::get('q');
        }

        $users = User::GetAll($keyword)->orderBy('created_at', 'desc')->paginate($paging);

        return view('backend.user.index', [
            'title'   => 'รายชื่อผู้ใช้งานในระบบทั้งหมด',
            'users'   => $users,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }

    public function getUserDetail ($user_id)
    {
        $user = User::where('id', $user_id)->first();
        return view('backend.user.user-detail', [
            'title'        => 'รายละเอียดผู้ใช้',
            'user'         => $user,
            'parent_pages' => [
                'url'   => action('BackendController@getUsers'),
                'title' => 'ผู้ใช้ทั้งหมด'
            ]
        ]);
    }

    public function getAdmin ($paging = 12)
    {
        $keyword = '';

        if ( Request::has('q') ) {
            $keyword = Request::get('q');
        }

        $admins = \BackendService::getAdmin($keyword);

        $admins = $admins->paginate($paging);

        return view('backend.admin.index', [
            'title'   => 'รายชื่อผู้ดูแลระบบทั้งหมด',
            'admins'  => $admins,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }

    public function getAdminDetail ($admin_id)
    {
        $admin = Admin::where('id', $admin_id)->first();

        if ( !$admin ) {
            return $this->onAdminNotFound();
        }

        return view('backend.admin.user-detail', [
            'title'        => 'รายละเอียดผู้ดูแลระบบ',
            '$admin'       => $admin,
            'parent_pages' => [
                'url'   => action('BackendController@getAdmin'),
                'title' => 'ผู้ดูแลระบบทั้งหมด'
            ]
        ]);
    }

    public function getSetAdminStatus ($admin_id, $status_name)
    {
        return \AdminService::setStatus($admin_id, $status_name, $this);
    }

    public function getAddAdmin ()
    {
        $admin_roles = AdminRole::get([ 'id', 'detail' ])->toArray();
        $admin_statuses = AdminStatus::get([ 'id', 'detail' ])->toArray();

        return view('backend.admin.admin-form', [
            'title'          => 'เพิ่มข้อมูลผู้ดูแลระบบ',
            'admin_roles'    => array_pluck($admin_roles, 'detail', 'id'),
            'admin_statuses' => array_pluck($admin_statuses, 'detail', 'id')
        ]);
    }

    public function postAddAdmin (AdminFormRequest $request)
    {
        return \AdminService::createAdmin($request->except('_token'), $this);
    }

    public function getEditAdmin ($admin_id)
    {
        $admin = \AdminService::findAdminById($admin_id);

        if ( !$admin ) {
            return $this->onAdminNotFound();
        }

        $admin_roles = AdminRole::get([ 'id', 'detail' ])->toArray();
        $admin_statuses = AdminStatus::get([ 'id', 'detail' ])->toArray();

        return view('backend.admin.admin-form', [
            'title'          => 'แก้ไขข้อมูลผู้ดูแลระบบ',
            'admin_roles'    => array_pluck($admin_roles, 'detail', 'id'),
            'admin_statuses' => array_pluck($admin_statuses, 'detail', 'id'),
            'admin'          => $admin
        ]);
    }

    public function postEditAdmin (AdminFormRequest $request)
    {
        return \AdminService::updateAdmin($request->except('_token'), $this);
    }

    public function getDeleteAdmin ($admin_id)
    {
        return \AdminService::deleteAdmin($admin_id, $this);
    }

    public function getAssociate ($paging = 10)
    {
        $keyword = '';

        if ( Request::has('q') ) {
            $keyword = Request::get('q');
        }

        $associates = \AssociateService::listAll($keyword);

        $associates = $associates->paginate($paging);

        return view('backend.associate.index', [
            'title'      => 'รายชื่อ Associate ทั้งหมด',
            'associates' => $associates,
            'keyword'    => $keyword,
            'paging'     => $paging
        ]);
    }

    public function getAssociateDetail ($associate_id)
    {
        $associate = \AssociateService::findById($associate_id);

        if ( !$associate ) {
            return $this->onAssociateNotFound('ไม่พบข้อมูล Associate ที่ต้องการ');
        }

        return view('backend.associate.detail', [
            'title'        => 'รายละเอียด Associate',
            'associate'    => $associate,
            'parent_pages' => [
                'url'   => action('BackendController@getAssociate'),
                'title' => 'รายชื่อ Associate ทั้งหมด'
            ]
        ]);
    }

    public function getDisableAssociate ($associate_id)
    {
        return \AssociateService::setDisable($associate_id, $this);
    }

    public function getActivateAssociate ($associate_id)
    {
        return \AssociateService::setActive($associate_id, $this);
    }

//    public function getDeleteUser($user_id)
//    {
//        $user = \App\User::find($user_id);
//
//        if($user) {
//            if($user->delete()) {
//                return redirect()->action('BackendController@getUsers')->with('message', 'ลบข้อมูลผู้ใช้งานเสร็จเรียบร้อย');
//            }
//
//            return redirect()->back()->withErrors(['message' => 'เกิดข้อผิดพลากในการลบข้อมูลผู้ใช้งาน']);
//        }
//        return redirect()->back()->withErrors(['messages' => 'ไม่พบข้อมูลผู้ใช้งานนี้']);
//    }
    public function getSetUserStatus ($user_id, $status_name)
    {
        $user = User::find($user_id);
        if ( $user ) {
            $user->user_status_id = \App\UserStatus::whereName($status_name)->first()->id;

            if ( Request::has('remark') ) {
                $user->remark = Request::get('remark');
            }

            if ( $user->save() ) {
                if ( $status_name == 'banned' ) {
                    $this->sendEmailUserBanned($user->id);
                }

                return redirect()->action('BackendController@getUsers')->with('message', 'บันทึกสถานะเสร็จเรียบร้อย');
            }

            return redirect()->back()->withErrors([ 'message' => 'เกิดข้อผิดพลากในการบันทึกสถานะผู้ใช้งาน' ]);
        }
        return redirect()->back()->withErrors([ 'messages' => 'ไม่พบผู้ใช้งานนี้' ]);
    }

    function sendEmailUserBanned ($user_id)
    {
        $user = User::find($user_id);

        \Mail::queue('backend.mail.ban', [
            'user'     => $user,
            'base_url' => url('/') . '/'
        ], function ($m) use ($user) {
            $m->to($user->email, $user->full_name)->subject('บัญชีผู้ใช้ของคุณถูกระงับ');
        });
    }
    /*
     * End User backend
     */

    /*
     * Payment
     */

//    public function getPayment($status = '')
//    {
//        $statuses = null;
//        $keyword = '';
//
//        $all_statuses = PaymentStatus::whereIn('name', [ 'transferred', 'paid', 'cancel' ])->get();
//
//        if (Request::has('q')) {
//            if (is_numeric(Request::get('q'))) {
//                $orders = Order::with('payment')->whereId(Request::get('q'))->paginate(20);
//
//                if ($orders) {
//                    return view('backend.payment.payment', [
//                        'title' => 'การแจ้งชำระเงิน',
//                        'orders' => $orders,
//                        'payment_statuses' => $all_statuses,
//                        'status_name' => $status
//                    ]);
//                }
//            }
//            $keyword = Request::get('q');
//        }
//
//        if ($status == '') {
//            $statuses = [
//                PaymentStatus::whereName('approve')->first()->id,
//                PaymentStatus::whereName('paid')->first()->id,
//                PaymentStatus::whereName('cancel')->first()->id,
//            ];
//        } else {
//            $statuses = [ PaymentStatus::whereName($status)->first()->id ];
//        }
//
//        $orders = Order::GetAll($keyword, $statuses)
//            ->orderBy('payment_status_id', 'asc')
//            ->orderBy('updated_at', 'dsc')
//            ->paginate(20);
//
//        return view('backend.payment.payment', [
//            'title' => 'การแจ้งชำระเงิน',
//            'orders' => $orders,
//            'payment_statuses' => $all_statuses,
//            'status_name' => $status
//        ]);
//    }


    public function getRefund ()
    {
        $orders = Order::allRefund(20);
        return view('backend.payback.refund', [
            'title'  => 'รายการจ่ายเงินคืน',
            'orders' => $orders
        ]);
    }

    public function getCommission ($paging = 10)
    {
        $keyword = '';

        if ( \Request::has('q') ) {
            $keyword = \Request::get('q');
        }

        $users = \CommissionService::payoutApproving($keyword);

        $users = $users->simplePaginate($paging);

        return view('backend.commissions.index', [
            'title'   => 'รายการส่วนแบ่ง',
            'users'   => $users,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }

    public function getPayoutDetail ($user_id)
    {
        $user = User::find($user_id);
        if ( !$user ) {
            abort(404);
        }
        $start = $user->monthly_commissions->first()->start;
        $end = $user->monthly_commissions->last()->end;

        $order_items = \CommissionService::allApprovedItem($user, $start, $end);
        $return_items = \CommissionService::allReturnItem($user, $start, $end);
        $return_commission = \CommissionService::sumReturnItem($user, $start, $end);
        $total_commission = \CommissionService::totalPendingCommission($user);
        $total_pending = $total_commission - $return_commission[ 'total' ];
        return view('backend.commissions.detail', [
            'title'             => 'รายละเอียดการจ่ายเงิน',
            'user'              => $user,
            'payout'            => null,
            'order_items'       => $order_items->get(),
            'return_items'      => $return_items->get(),
            'return_commission' => $return_commission[ 'total' ],
            'total_commission'  => $total_commission,
            'total_pending'     => $total_pending,
            'start'             => $start,
            'end'               => $end
        ]);
    }

    public function getApproveCommission ($user_id)
    {
        return \CommissionService::createPayout($user_id, $this);
    }

    public function getCommissionApproved ($paging = 10)
    {
        $keyword = '';

        if ( \Request::has('q') ) {
            $keyword = \Request::get('q');
        }

        $payouts = \CommissionService::payoutApproved();
        $payouts = $payouts->paginate($paging);
        return view('backend.commissions.approved', [
            'title'   => 'รายการส่วนแบ่งที่ได้รับการอนุมัติแล้ว',
            'payouts' => $payouts,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }

    public function getPayoutTransferDetail ($payout_id)
    {
        $payout = Payout::find($payout_id);
        $order_items = \CommissionService::allApprovedItem($payout->user, $payout->start, $payout->end);
        $return_items = \CommissionService::allReturnItem($payout->user, $payout->start, $payout->end);
        $return_commission = \CommissionService::sumReturnItem($payout->user, $payout->start, $payout->end);
        $total_commission = \CommissionService::totalPendingCommission($payout->user);
        $total_pending = $payout->total - $payout->return_total;

        if ( !$payout ) {
            abort(404);
        }

        return view('backend.commissions.detail', [
            'title'             => 'รายละเอียดการจ่ายเงิน',
            'user'              => $payout->user,
            'payout'            => $payout,
            'order_items'       => $order_items->get(),
            'return_items'      => $return_items->get(),
            'return_commission' => $payout->return_total,
            'total_commission'  => $payout->total,
            'total_pending'     => $total_pending,
            'start'             => $payout->start,
            'end'               => $payout->end
        ]);
    }

    public function postUpdatePayout ($payout_id)
    {
        return \CommissionService::updatePayoutTransferData($payout_id, \Request::except([ '_token' ]));
    }

    public function getResetPayoutTransfer ($payout_id)
    {
        return \CommissionService::resetPayoutTransferData($payout_id);
    }

    public function getRequestTransfer ()
    {
        return view('backend.commissions.request-detail', [ 'title' => 'จ่ายเงิน' ]);
    }

    public function getCommissionDetail ()
    {
        $request = '';
        return view('backend.commissions.request-detail', [
            'title'   => 'การยื่นขอโอนเงิน',
            'request' => $request
        ]);
    }

    public function getCommissionHistory ($paging = 10)
    {
        $keyword = '';

        if ( \Request::has('q') ) {
            $keyword = \Request::get('q');
        }

        $payouts = \CommissionService::payoutPaid($keyword);
        $payouts = $payouts->paginate($paging);
        return view('backend.commissions.history', [
            'title'   => 'รายการส่วนแบ่งที่ได้รับการอนุมัติแล้ว',
            'payouts' => $payouts,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }
//    public function getTransferDetail ()
//    {
//        $request = '';
//        return view('backend.commissions.transfer-detail', [
//            'title'   => 'รายละเอียดการโอนเงินส่วนแบ่ง',
//            'request' => $request
//        ]);
//    }

    public function getPayback ()
    {
        return view('backend.payback.index', [
            'title' => 'รายการคืนเงิน',
        ]);

    }

    public function getSetPayoutTransferred ($order_id)
    {
        if ( !Request::has('transferred_on') ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูล' ]);
        }

        $order = Order::find($order_id);

        if ( !$order ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลการสั่งซื้อ' ]);
        }

        $inputs = Request::all();
        $date = explode(' ', $inputs[ 'transferred_on' ]);
        $transfer_date = explode('/', $date[ 0 ]);
        $transfer_time = explode(':', $date[ 1 ]);
        if ( $order->payout->first() ) {

            $payout = $order->payout->first();

            if ( $payout->type->name == 'refund' ) {
                $payout->total = $payout->order->payment->first()->total;
            } elseif ( $payout->type->name == 'profit' ) {
                $payout->total = $payout->campaign->totalProfit();
            }

            $payout->bank_no = $payout->user->bank_account->no;
            $payout->bank_name = $payout->user->bank_account->bank_name;
            $payout->branch = $payout->user->bank_account->branch;
            $payout->status()->associate(PayoutStatus::whereName('finish')->first());
            $payout->transferred_on = \Carbon::create($transfer_date[ 2 ], $transfer_date[ 1 ], $transfer_date[ 0 ], $transfer_time[ 0 ], $transfer_time[ 1 ]);
            if ( $payout->update() ) {
                return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
            }
        } else {
            $payout = \App\Payout::create([
                'total'            => $order->payment->first()->total,
                'bank_no'          => $order->user->bank_account->no,
                'bank_name'        => $order->user->bank_account->bank_name,
                'branch'           => $order->user->bank_account->branch,
                'transferred_on'   => \Carbon::create($transfer_date[ 2 ], $transfer_date[ 1 ], $transfer_date[ 0 ], $transfer_time[ 0 ], $transfer_time[ 1 ]),
                'payout_status_id' => PayoutStatus::whereName('finish')->first()->id,
                'payout_type_id'   => PayoutType::whereName('refund')->first()->id,
                'campaign_id'      => $order->campaign_id,
                'order_id'         => $order->id,
                'user_id'          => $order->user->id
            ]);

            if ( $payout ) {
                return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
            }
        }

        return response()->json([ 'success' => false, 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);

    }

    public function getSetProfitTransferred ($campaign_id)
    {
        if ( !Request::has('transferred_on') ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูล' ]);
        }

        $campaign = Campaign::with('user')->where('id', $campaign_id)->first();

        if ( !$campaign ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลแคมเปญ' ]);
        }

        $inputs = Request::all();
        $date = explode(' ', $inputs[ 'transferred_on' ]);
        $transfer_date = explode('/', $date[ 0 ]);
        $transfer_time = explode(':', $date[ 1 ]);
        if ( $campaign->payout->first() ) {

            $payout = $campaign->payout->first();

            $payout->total = $campaign->totalProfit();
            $payout->bank_no = $campaign->user->bank_account->no;
            $payout->bank_name = $campaign->user->bank_account->bank_name;
            $payout->branch = $campaign->user->bank_account->branch;
            $payout->status()->associate(PayoutStatus::whereName('finish')->first());
            $payout->transferred_on = \Carbon::create($transfer_date[ 2 ], $transfer_date[ 1 ], $transfer_date[ 0 ], $transfer_time[ 0 ], $transfer_time[ 1 ]);
            if ( $payout->update() ) {
                return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
            }
        } else {
            $payout = \App\Payout::create([
                'total'            => $campaign->totalProfit(),
                'bank_no'          => $campaign->user->bank_account->no,
                'bank_name'        => $campaign->user->bank_account->bank_name,
                'branch'           => $campaign->user->bank_account->branch,
                'transferred_on'   => \Carbon::create($transfer_date[ 2 ], $transfer_date[ 1 ], $transfer_date[ 0 ], $transfer_time[ 0 ], $transfer_time[ 1 ]),
                'payout_status_id' => PayoutStatus::whereName('finish')->first()->id,
                'payout_type_id'   => PayoutType::whereName('profit')->first()->id,
                'campaign_id'      => $campaign->id,
                'user_id'          => $campaign->user->id
            ]);

            if ( $payout ) {
                return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
            }
        }

        return response()->json([ 'success' => false, 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);

    }

    public function getUpdateOrder ($order_id)
    {
        $order = Order::with('shipping_address')->where('id', $order_id)->first();
        if ( !$order ) {
            return 'Order Not found';
        }

        return view('backend.orders.edit', [
            'title' => 'แก้ไขการสั่งซื้อ ' . str_pad($order->id, 6, 0, STR_PAD_LEFT),
            'order' => $order
        ]);
    }

    public function postUpdateOrder ()
    {
        $inputs = Request::all();

        $order = Order::find($inputs[ 'order_id' ]);

        if ( !$order ) {
            return 'Order Not found';
        }

        $order->campaign_id = $inputs[ 'campaign_id' ];
        $order->payment_type()->associate(\App\PaymentType::whereName($inputs[ 'payment_type' ])->first());
        $order->shipping_type()->associate(\App\ShippingType::whereName($inputs[ 'shipping_type' ])->first());
        $shipping_address = $order->shipping_address;

        $shipping_address->full_name = $inputs[ 'full_name' ];
        $shipping_address->address = $inputs[ 'address' ];
        $shipping_address->building = $inputs[ 'building' ];
        $shipping_address->district = $inputs[ 'district' ];
        $shipping_address->province = $inputs[ 'province' ];
        $shipping_address->zipcode = $inputs[ 'zipcode' ];
        $shipping_address->phone = $inputs[ 'phone' ];
        $shipping_address->email = $inputs[ 'email' ];

        if ( !$shipping_address->update() ) {
            return redirect()->back()->withErrors([ 'การบันทึกข้อมูลจัดส่งผิดพลาด' ]);
        }

        if ( $order->update() ) {
            return redirect()->action('BackendController@getOrder')->with([ 'messages' => 'การบันทึกการสั่งซื้อเสร็จเรียบร้อย' ]);
        }

        return redirect()->back()->withErrors[ 'การบันทึกการสั่งซื้อผิดพลาด' ];
    }

    public function getLoadPaymentData ($payment_id)
    {
        if ( $payment_id != '' ) {
            $payment = Payment::find($payment_id);

            if ( $payment ) {
                return response()->json([ 'result' => true, 'payment' => $payment->toArray() ]);
            }

            return response()->json([ 'result' => false, 'message' => 'ไม่พบข้อมูลการชำระเงิน' ]);
        }

        return response()->json([ 'result' => false, 'message' => 'ไม่มีข้อมูลหมายเลขการชำระเงิน' ]);
    }

    /*
     * Report section
     */

    public function getReport ()
    {
        $reports = \App\Report::where('is_opened', false)->paginate(20);

        return view('backend.report.index', [
            'title'   => 'การรายงานแคมเปญและผู้ใช้งานผิดกฏ',
            'reports' => $reports
        ]);
    }



    /*
     * New System function
     */
    /**
     * Add new product
     *
     * @return \Illuminate\View\View
     */
    public function getAddProduct ()
    {
        $categories = Category::all();
        return view('backend.products.add', [
            'title'      => 'เพิ่มสินค้า',
            'categories' => $categories
        ]);
    }

    /**
     * Save product to database
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postSaveProduct ()
    {
        $inputs = Request::all();
        try {
            \DB::beginTransaction();
            $product = Product::create([
                'name'           => $inputs[ 'name' ],
                'price'          => $inputs[ 'price' ],
                'one_side_price' => $inputs[ 'one_side_price' ],
                'max_price'      => $inputs[ 'max_price' ],
                'category_id'    => $inputs[ 'category_id' ]
            ]);

            if ( !$product ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลสินค้าได้กรุณาลองใหม่' ]);
            }

            $product->outline()->save(new ProductOutline());

            if ( !\Request::hasFile('size_chart_file') ) {
                throw new \Exception('ไม่มีไฟล์รูปภาพตารางขนาดเสื้อ');
            }
            $file = \Request::file('size_chart_file');

            $ext = $file->getClientOriginalExtension();

            $file_name = 'size-chart-' . str_pad($product->id, 6, 0, STR_PAD_LEFT) . '.' . $ext;
            \ImageService::upload(\Request::file('size_chart_file'),
                'images/products/' . str_pad($product->id, 6, 0, STR_PAD_LEFT),
                $file_name);

            $product->size_chart = action('ProductController@getFile', [ $product->id, $file_name ]);

            $product->save();
            \DB::commit();

            return redirect()->action('BackendController@getProduct')->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
        } catch ( \Exception $ex ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ $ex->getMessage() ]);
        }
//        ProductOutline::create([ 'id' => $product->id ]);

//        $productDescription = array_only($inputs, [
//            's_width', 's_height',
//            'm_width', 'm_height',
//            'l_width', 'l_height',
//            'xl_width', 'xl_height',
//            'xxl_width', 'xxl_height',
//        ]);
//
//        $productDescription[ 'id' ] = $product->id;
//
//        ProductDescription::create($productDescription);

    }

    /**
     * Edit product
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getEditProduct ($id)
    {
        $product = Product::with('description')->whereId($id)->first();
        $categories = Category::all();
        return view('backend.products.edit', [
            'title'      => 'แก้ไขข้อมูลสินค้า ',
            'sub_title'  => $product->name,
            'product'    => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update product in database
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws
     */
    public function postUpdateProduct ()
    {
        $inputs = Request::all();

        $product = Product::find($inputs[ 'id' ]);

        try {
            \DB::beginTransaction();
            $product->update([
                'name'           => $inputs[ 'name' ],
                'price'          => $inputs[ 'price' ],
                'one_side_price' => $inputs[ 'one_side_price' ],
                //            'two_side_price' => $inputs['price'] + Cost::whereName('print_two_side')->first()->value,
                'max_price'      => $inputs[ 'max_price' ],
                'category_id'    => $inputs[ 'category_id' ],
            ]);

//        $product->description()->update(array_only($inputs, [
//            'full_detail',
//            's_width', 's_height',
//            'm_width', 'm_height',
//            'l_width', 'l_height',
//            'xl_width', 'xl_height',
//            'xxl_width', 'xxl_height',
//        ]));
            if ( \Request::hasFile('size_chart_file') ) {

                $file = \Request::file('size_chart_file');

                $ext = $file->getClientOriginalExtension();

                $file_name = 'size-chart-' . str_pad($product->id, 6, 0, STR_PAD_LEFT) . '.' . $ext;
                \ImageService::upload(\Request::file('size_chart_file'),
                    'images/products/' . str_pad($product->id, 6, 0, STR_PAD_LEFT),
                    $file_name);

                $product->size_chart = action('ProductController@getFile', [ $product->id, $file_name ]);
            }

            if ( !$product->save() ) {
                throw \Exception('ไม่สามารถบันทึกข้อมูลได้');
            }

            \DB::commit();

            return redirect()->action('BackendController@getProduct')->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
        } catch ( \Exception $ex ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ $ex->getMessage() ]);
        }
    }

    /**
     * Add new product image and product sku
     *
     * @return \Illuminate\View\View
     */
    public function getAddProductColor ($product_id)
    {
        $product = Product::find($product_id);

        if ( !$product ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลสินค้ากรุณาลองใหม่' ]);
        }
        return view('backend.products.add-product-image', [
            'title'   => 'เพิ่มข้อมูลสินค้า',
            'product' => $product
        ]);
    }

    /**
     * Save product image to database
     *
     * @param $product_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postAddProductColor ($product_id)
    {
        $product = Product::find($product_id);

        if ( !$product ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลสินค้ากรุณาลองใหม่' ]);
        }

//        if (!Request::hasFile('image_front') || !Request::hasFile('image_back')) {
//            return redirect()->back()->withErrors([ 'ไม่มีข้อมูลรูปภาพสินค้า' ]);
//        }
        $inputs = Request::all();
        $base_id = str_pad($product_id, 6, 0, STR_PAD_LEFT);
        $base_directory = 'images/products/' . $base_id . '/';
        $uid = uniqid();
        $image_front = '';
        $image_back = '';
        if ( \Request::hasFile('image_front') ) {
            $image_front = 'image-front-' . $uid . '.' . Request::file('image_front')->getClientOriginalExtension();

            if ( !$this->uploadFile($base_directory, $image_front, $inputs[ 'image_front' ], true) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกรูปภาพด้านหน้าได้' ]);
            }
        }
        if ( \Request::hasFile('image_back') ) {
            $image_back = 'image-back-' . $uid . '.' . Request::file('image_back')->getClientOriginalExtension();

            if ( !$this->uploadFile($base_directory, $image_back, $inputs[ 'image_back' ], true) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกรูปภาพด้านหลังได้' ]);
            }
        }

        $product_color = ProductColor::create([
            'color'       => $inputs[ 'color' ],
            'color_name'  => $inputs[ 'color_name' ],
            'image_front' => $base_id . '/' . $image_front,
            'image_back'  => $base_id . '/' . $image_back,
            'product_id'  => $product->id
        ]);

        foreach ( config('constant.available_sizes') as $size ) {
            $is_active = true;

            $result = array_filter($inputs[ 'sizes' ], function ($value) use ($size) {
                return $value == $size;
            });

            if ( !head($result) ) {
                $is_active = false;
            }

            $product_sku = ProductSku::create([
                'size'             => $size,
                'product_color_id' => $product_color->id,
                'is_active'        => $is_active
            ]);
        }

        return redirect()->action('BackendController@getEditProduct', $product_id);
    }

    /**
     * Edit product image and product sku
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getEditProductColor ($id)
    {
        $product_color = ProductColor::find($id);

        return view('backend.products.edit-product-image', [
            'title'         => 'แก้ไขข้อมูลสินค้า',
            'product_color' => $product_color
        ]);
    }

    /**
     * Update product image and sku
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUpdateProductColor ($id)
    {
        $mime_type = config('constant.allow_mime_type');
        $product_color = ProductColor::with('sku')->whereId($id)->first();

        if ( !$product_color ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลสินค้า' ]);
        }

        if ( Request::hasFile('image_front') ) {
            if ( !Request::hasFile('image_back') ) {
                return redirect()->back()->withErrors([ 'ไม่มีข้อมูลรูปภาพสินค้าด้านหลัง' ]);
            }
        } else if ( Request::hasFile('image_back') ) {
            if ( !Request::hasFile('image_front') ) {
                return redirect()->back()->withErrors([ 'ไม่มีข้อมูลรูปภาพสินค้าด้านหน้า' ]);
            }
        }

        $inputs = Request::all();

        // Has both front and back image can save
        if ( Request::hasFile('image_front') && Request::hasFile('image_back') ) {
            // allow only picture jpg and png file type
            if ( !in_array($inputs[ 'image_front' ]->getMimeType(), $mime_type) ) {
                return redirect()->back()->withErrors([ 'อนุญาติให้อัพโหลดเฉพาะไฟล์รูปภาพแบบ JPG และ PNG เท่านั้น' ]);
            }

            if ( !in_array($inputs[ 'image_back' ]->getMimeType(), $mime_type) ) {
                return redirect()->back()->withErrors([ 'อนุญาติให้อัพโหลดเฉพาะไฟล์รูปภาพแบบ JPG และ PNG เท่านั้น' ]);
            }
            $base_directory = 'images/products/' . str_pad($product_color->product_id, 6, 0, STR_PAD_LEFT) . '/';
            $uid = uniqid();
            $image_front = 'image-front-' . $uid . '.' . Request::file('image_front')->getClientOriginalExtension();
            $image_back = 'image-back-' . $uid . '.' . Request::file('image_back')->getClientOriginalExtension();

            if ( !$this->uploadFile($base_directory, $image_front, $inputs[ 'image_front' ]) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกรูปภาพด้านหน้าได้' ]);
            }

            if ( !$this->uploadFile($base_directory, $image_back, $inputs[ 'image_back' ]) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกรูปภาพด้านหลังได้' ]);
            }
            $this->deleteFile($product_color->image_front);
            $this->deleteFile($product_color->image_back);

            $product_color->image_front = $base_directory . $image_front;
            $product_color->image_back = $base_directory . $image_back;
        }
        $product_color->color = $inputs[ 'color' ];
        $product_color->color_name = $inputs[ 'color_name' ];
        $product_color->sku()->whereNotIn('size', $inputs[ 'size_has' ])->update([ 'is_active' => false ]);
        $product_color->sku()->whereIn('size', $inputs[ 'size_has' ])->update([ 'is_active' => true ]);

        if ( !$product_color->save() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->action('BackendController@getEditProduct', $product_color->product_id);
    }


    /*
     * File upload and copy
     */


    /**
     * File upload and save to storage
     *
     * @param              $destination
     * @param              $file_name
     * @param UploadedFile $fileContent
     * @return bool
     */
    private
    function uploadFile ($destination, $file_name, UploadedFile $fileContent)
    {
        \Storage::makeDirectory($destination);

        return \Storage::disk('local')->put($destination . $file_name, \File::get($fileContent));
    }


    /**
     * File copy or move
     *
     * @param            $original
     * @param            $destination
     * @param bool|false $move
     * @return bool
     */
    function copyFile ($original, $destination, $move = false)
    {
        if ( !\Storage::exists($original) ) {
            return false;
        }
        if ( $move ) {
            if ( \Storage::move($original, $destination) ) {
                return true;
            }
        } else {
            if ( \Storage::copy($original, $destination) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Delete file
     *
     * @param $path
     * @return bool
     */
    private
    function deleteFile ($path)
    {
        if ( !\Storage::exists($path) ) {
            return true;
        }

        return \Storage::delete($path);
    }

    public function getCampaign ($paging = 16)
    {
        $keyword = '';
        $criteria = 'id';

        $campaigns = Campaign::whereHas('user', function ($query) {
            $query->whereNotNull('id');
        })->orderBy('created_at', 'desc');
        if ( Request::has('q') ) {
            $keyword = Request::get('q');
            if ( Request::has('criteria') ) {
                $criteria = Request::get('criteria');
            }

            if ( $criteria == 'id' ) {
                $campaigns = $campaigns->where('id', $keyword);
            } else if ( $criteria == 'title' ) {
                $campaigns = $campaigns->where('title', 'LIKE', '%' . $keyword . '%');
            } else if ( $criteria == 'creator_name' ) {
                $campaigns = $campaigns->whereHas('user', function ($query) use ($keyword) {
                    $query->where('full_name', 'LIKE', '%' . $keyword . '%');
                });
            } else if ( $criteria == 'creator_id' ) {
                $campaigns = $campaigns->whereHas('user', function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            } else if ( $criteria == 'tag' ) {
                $campaigns = $campaigns->whereHas('tags', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                });
            }
        }
        $campaigns = $campaigns->paginate($paging);

        return view('backend.campaign.index', [
            'title'     => 'แคมเปญ',
            'campaigns' => $campaigns,
            'keyword'   => $keyword,
            'criteria'  => $criteria,
            'paging'    => $paging,
        ]);
    }


    // Order system
    public function getOrder ($paging = 12)
    {
        $orders = Order::has('payment')->with('payment_status')->whereHas('shipping_address', function ($q) {
        });

        $keyword = '';
        if ( Request::has('q') ) {
            $keyword = Request::get('q');
            $orders = $orders->where('id', $keyword)
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('users.full_name', 'like', '%' . $keyword . '%');
                });
        }

        $orders = $orders->orderBy('id', 'dsc')->paginate($paging);
        return view('backend.orders.index', [
            'title'   => 'รายการสั่งซื้อ',
            'orders'  => $orders,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }

    /**
     * Order detail view
     *
     * @param $id
     * @return mixed
     */

    public function getOrderDetail ($id)
    {
        $order = Order::with('items')->whereId($id)->first();

        if ( !$order ) {
            return redirect()->back()->withErrors([ 'ไม่มีข้อมูลการสั่งซื้อเลขที่ ' . $id ]);
        }

        $step = 0;
        if ( $order->payment_status->name == 'approve' ) {
            $step = 1;
        }
        if ( $order->payment_status->name == 'paid' ) {
            $step = 2;
        }
        if ( $order->status->name == OrderStatus::PRODUCING ) {
            $step = 3;
        }
        if ( $order->status->name == OrderStatus::SHIPPING ) {
            $step = 4;
        }
        if ( $order->status->name == OrderStatus::SHIPPED ) {
            $step = 5;
        }

        return view('backend.orders.detail', [
            'title'        => 'ข้อมูลการสั่งซื้อเลขที่ ' . $id,
            'order'        => $order,
            'step'         => $step,
            'return_order' => null,
            'parent_pages' => [
                'url'   => action('BackendController@getOrder'),
                'title' => 'รายการสั่งซื้อ'
            ]
        ]);
    }

    public function postReturnOrder ($order_id)
    {
        return \OrderService::returnOrder($order_id, \Request::except('_token'), $this);
    }
    /**
     * Confirm payment update
     *
     * @param $payment_id
     * @return mixed
     * @internal param $order_id
     */
    public function getConfirmPayment ($payment_id)
    {
        return \OrderService::confirmPayment($payment_id, $this);
    }

    /**
     * Cancel payment update
     *
     * @param $payment_id
     * @return mixed
     * @internal param $order_id
     */
    public function getCancelPayment ($payment_id)
    {
        return \OrderService::cancelPayment($payment_id, $this);
    }

    /**
     * Reset payment update to approve
     *
     * @param $payment_id
     * @return mixed
     * @internal param $order_id
     */
    public function getResetUpdatePayment ($payment_id)
    {
        return \OrderService::resetTransferPayment($payment_id, $this);
    }

    /**
     * Admin manually create payment update
     *
     * @param $id
     * @return mixed
     */
    public function postUpdatePayment ($id)
    {
        $inputs = Request::all();
        $order = Order::find($id);
        if ( !$order ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลการสั่งซื้อเลขที่ : ' . $id ]);
        }

        $payment = $order->payment()->first();

        if ( !$payment ) {
            $payment = new Payment();
        }

        $payment->total = intVal($inputs[ 'total' ]);
        $payment->from_bank = $inputs[ 'from_bank' ];
        $payment->to_bank = $inputs[ 'to_bank' ];
        $payment->confirmed_at = \Carbon::now();
        $payment->pay_on = \Carbon::createFromFormat('d/m/Y H:i', $inputs[ 'transferred_on' ]);

        if ( !$order->payment()->save($payment) ) {
            return redirect()->back()->withErrors([ 'ไม่สมารถบันทึกข้อมูลการชำระเงินได้กรุณาลองใหม่' ]);
        }

        $order->payment_status()->associate(PaymentStatus::whereName('paid')->first());

        if ( !$order->update() ) {
            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);
        }

        return redirect()->back()->with('message', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function getPayment ($paging = 12)
    {
        $statuses = [ 'approve', 'paid' ];
        $payment_statuses = PaymentStatus::whereIn('name', $statuses);
        $status_ids = array_flatten($payment_statuses->get([ 'id' ])->toArray());
        $orders = Order::whereIn('payment_status_id', $status_ids);
        $payments = \DB::table('payments')
            ->leftJoin('orders', 'payments.order_id', '=', 'orders.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('payment_statuses', 'orders.payment_status_id', '=', 'payment_statuses.id');

        $keyword = '';
        if ( Request::has('q') && Request::get('q') != '' ) {
            $keyword = Request::get('q');
            $orders = $orders->where('id', $keyword)
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('users.full_name', 'like', '%' . $keyword . '%');
                });
            $payments = $payments->where('orders.id', $keyword)->orWhere('users.full_name', 'LIKE', '%' . $keyword . '%');
        }
        $orders = $orders->has('payment')
            ->with('user')
            ->orderBy('payment_status_id')
            ->orderBy('created_at', 'desc')
            ->paginate($paging);
        $payments = \OrderService::getPayment($status_ids, $keyword)->get();
        return view('backend.payment.index', [
            'title'            => 'การแจ้งชำระเงิน',
            'orders'           => $orders,
            'payment_statuses' => $payment_statuses->get(),
            'payments'         => $payments,
            'keyword'          => $keyword,
            'paging'           => $paging
        ]);
    }

    public function getPaymentDetail ($payment_id)
    {
        $payment = Payment::has('order')->with('order')->active()->whereId($payment_id)->first();

        if ( !$payment ) {
            return redirect()->action('BackendController@getPayment')->withErrors([ 'ไม่มีข้อมูลการแจ้งชำระเงิน เลขที่ : ' . $payment_id ]);
        }

        $nearest_payments = \OrderService::nearestPayment($payment->id);

        return view('backend.payment.detail', [
            'title'            => 'รายละเอียดการแจ้งชำระเงิน ของหมายเลขสั่งซื้อ #' . $payment->order->id,
            'payment'          => $payment,
            'nearest_payments' => $nearest_payments,
            'parent_pages'     => [
                'url'   => action('BackendController@getPayment'),
                'title' => 'การแจ้งชำระเงิน'
            ]
        ]);
    }

    // Producing system

    /**
     * Show all order is ready to produce
     *
     * @return \Illuminate\View\View
     */
    public function getWaitingProduce ()
    {
        $orders = \OrderService::waitingProduce()->paginate(10);
        return view('backend.manufacture.waiting-produce', [
            'icon'   => '<i class="fa  fa-clock-o text-red"></i>',
            'title'  => 'รอดำเนินการผลิต',
            'orders' => $orders
        ]);
    }

    /**
     * Show all order is producing status
     *
     * @return \Illuminate\View\View
     */
    public function getProducing ()
    {
        $orders = \OrderService::producing();
        $order_id = $orders->get([ 'id' ])->toArray();
        $orders = $orders->paginate(10);
        $data = \OrderService::prepareShirt($order_id);

        return view('backend.manufacture.producing', [
            'icon'          => '<span class="glyphicon glyphicon-hourglass text-yellow"></span>',
            'title'         => 'กำลังผลิต',
            'orders'        => $orders,
            'prepare_shirt' => $data
        ]);
    }

    /**
     * Cancel order and set to refund money
     *
     * @param $order_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getSetCancelRefund ($order_id)
    {
        return \BackendService::cancelProduce($order_id, $this);
    }

    public function getCancelProduce ($order_id)
    {
        return \BackendService::cancelProduce($order_id, $this);
    }

    public function getWaitingTransport ()
    {
        $orders = \OrderService::shipping()->paginate(10);
        return view('backend.transport.waiting-transport', [
            'icon'   => '<i class="fa fa-cubes text-red"></i>',
            'title'  => 'รอดำเนินการจัดส่ง',
            'orders' => $orders
        ]);
    }

    public function getTransport ($paging = 10)
    {
        $keyword = '';

        if ( \Request::has('q') ) {
            $keyword = \Request::get('q');
        }

        $orders = \OrderService::getShipped($keyword)->paginate($paging);

        return view('backend.transport.transport', [
            'icon'    => '<i class="fa fa-truck text-green"></i>',
            'title'   => 'การจัดส่ง',
            'orders'  => $orders,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }

    public function getShippingDetail ($order_id)
    {
        $order = Order::whereId($order_id)->first();
        return view('backend.transport.edit', [
            'icon'  => '<i class="fa fa-truck text-green"></i>',
            'title' => 'รายละเอียดการจัดส่ง หมายเลขสั่งซื้อ: #' . str_pad($order->id, 6, 0, STR_PAD_LEFT),
            'order' => $order
        ]);
    }

    public function postUpdateShippingDetail ($order_id)
    {
        $order = Order::whereId($order_id)->first();

        if ( !$order->shipping_address()->update(\Request::except('_token')) ) {
            return redirect()->back()->withErrors([ 'ไม่สามาถบันทึกข้อมูลได้' ]);
        }

        return redirect()->action('BackendController@getTransport')->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
    }

    /**
     * Set producing status to order
     *
     * @param $order_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getSetProducing ($order_id)
    {
        $order = Order::getPaid($order_id)->first();

        if ( !$order ) {
            return redirect()->back()->withErrors([ 'ไม่พบการสั่งซื้อเลขที่ : ' . $order_id ]);
        }

        if ( !$order->setProducing() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกสถานะได้' ]);
        }

        if ( !\OrderTrackingService::createProducing($order) ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกสถานะได้' ]);
        }

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว' ]);
    }

    /**
     * Set produced status to order
     *
     * @param $order_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getSetProduced ($order_id)
    {
        $order = Order::getPaid($order_id)->first();

        if ( !$order ) {
            return redirect()->back()->withErrors([ 'ไม่พบการสั่งซื้อเลขที่ : ' . $order_id ]);
        }

        if ( !$order->setProduced() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกสถานะได้' ]);
        }

        if ( !\OrderTrackingService::createProduced($order) ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกสถานะได้' ]);
        }

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว' ]);
    }


    /**
     * Print customer address from order
     *
     * @return \Illuminate\View\View
     */
    public function getPrintCustomerAddress ($id)
    {
        $order = Order::find($id);

        return view('backend.manufacture.new-label', [
            'title' => 'พิมพ์ใบปะหน้าที่อยู่ลูกค้า',
            'order' => $order
        ]);
    }

    /**
     * Save art file from all campaign in order
     *
     * @param $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderArt ($order_id)
    {
        $order = Order::find($order_id);

        $temp_dir = 'tmp/';
        $file_suffix = '-art.zip';
        $file_name = 'order-' . $order->id . $file_suffix;

        // Delete existing file

        if ( \File::exists($temp_dir . $file_name) ) {
            \File::delete($temp_dir . $file_name);
        }

        $zipper = new Zipper;
        $zipper->make($temp_dir . $file_name);
        foreach ( $order->items as $item ) {
            $zipper->folder('order-' . str_pad($order->id, 6, 0, STR_PAD_LEFT) . '/campaign-' . str_pad($item->campaign_id, 6, 0, STR_PAD_LEFT))->add(storage_path('app/images/campaigns/' . str_pad($item->campaign_id, 6, 0, STR_PAD_LEFT)));

        }
        $zipper->close();
        $path = (url('/') . '/tmp/' . $file_name);
        return response()->json([ 'error' => false, 'file_url' => $path ]);
    }

    /**
     * Zip art file for one campaign
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampaignArt ($id)
    {
        $campaign = Campaign::find($id);

        $temp_dir = 'tmp/';
        $file_suffix = '-art.zip';
        $file_name = 'campaign-' . $campaign->id . $file_suffix;

        // Delete existing file
        if ( \Storage::exists($temp_dir . $file_name) ) {
            \Storage::delete($temp_dir . $file_name);
        }

        $files = glob(storage_path('app/images/campaigns/' . str_pad($campaign->id, 6, 0, STR_PAD_LEFT) . '/*'));
        $zipper = new Zipper;

        $zipper->make($file_name)->add($files);

        $zipper->close();
        $path = (url('/') . '/' . $file_name);
        return response()->json([ 'error' => false, 'file_url' => $path ]);
    }

    public function getSetShipped ($order_id)
    {
        try {
            \DB::beginTransaction();
            $order = Order::find($order_id);
            if ( !$order ) {
                return redirect()->back()->withErrors([ 'ไม่พบข้อมูลการสั่งซื้อเลขที่ : ' . $order_id ]);
            }

            if ( !\Request::has('tracking_code') ) {
                return redirect()->back()->withErrors([ 'ไม่มีหมายเลข Tracking ' ]);
            }

            if ( !$order->updateTrackingCode(\Request::get('tracking_code')) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกหมายเลข Tracking ได้' ]);
            }

            if ( !$order->setShipped() ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลสถานะได้' ]);
            }

            if ( !\OrderTrackingService::createShipped($order, \Request::get('tracking_code')) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกสถานะได้' ]);
            }

            \NotificationService::create(
                $order->user->id,
                NotificationType::USER,
                'สินได้ถูกจัดส่งเรียบร้อยแล้ว',
                action('UserController@getShowOrder', [ $order->user->getID(), $order->id ]
                ));


            return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลสถานะ เรียบร้อยแล้ว' ]);
        } catch(Exception $ex) {
            \DB::rollback();
            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง : ' . $ex->getMessage() ]);
        }
    }

    /**
     * Set status produced to order item in backend producing
     *
     * @param $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItemProduced ($item_id)
    {
        $item = OrderItem::find($item_id);

        if ( !$item ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลรายการสั่งซื้อ' ]);
        }

        $item->produced = !$item->produced;
        $item->produced_at = \Carbon::now();
        if ( !$item->save() ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
    }


    public function getSetApprove ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return abort(404);
        }

        $campaign->is_active = !$campaign->is_active;

        if ( !$campaign->save() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
    }

    public function getSetRecommended ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return abort(404);
        }

        $campaign->is_recommended = !$campaign->is_recommended;

        if ( !$campaign->save() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
    }

    public function getSetHot ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return abort(404);
        }

        $campaign->is_hot = !$campaign->is_hot;

        if ( !$campaign->save() ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->back()->with([ 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);
    }

    public function getCoupon ()
    {
        return view('backend.coupon.index', [
            'title' => 'Admin Dashboard',
        ]);
    }

    public function getAddCoupon ()
    {
        return view('backend.coupon.add', [
            'title' => 'Admin Dashboard',

        ]);
    }

    public function getEditCoupon ()
    {
        return view('backend.coupon.edit', [
            'title' => 'Admin Dashboard',
        ]);
    }

    public function getCouponDetail ()
    {
        return view('backend.coupon.view', [
            'title' => 'Admin Dashboard',

        ]);
    }

    /*
     * End new system function
     */

    public function getMonthlyCommission ($paging = 10)
    {
        $keyword = '';

        if ( \Request::has('q') ) {
            $keyword = \Request::get('q');
        }

        $start = \Carbon::now()->subMonth()->startOfMonth()->startOfDay();
        $users = CommissionService::userReadyApprove($keyword);
        return view('backend.monthly-commissions.index', [
            'title'   => 'รายการส่วนแบ่งรายเดือน',
            'users'   => $users->paginate(20),
            'start'   => $start,
            'keyword' => $keyword,
            'paging'  => $paging
        ]);
    }

    public function getMonthlyCommissionDetail ($user_id, $monthly_commission_id = '')
    {
        $detail = CommissionService::monthlyCommissionDetail($user_id, $monthly_commission_id, $this);
        return view('backend.monthly-commissions.detail', [
            'title'       => 'รายละเอียดส่วนแบ่ง',
            'order_items' => $detail[ 'order_items' ],
            'user'        => $detail[ 'user' ],
            'start'       => $detail[ 'start' ],
            'end'         => $detail[ 'end' ]
        ]);
    }

    public function getMonthlyCommissionApprove ($user_id = '')
    {
        $result = \CommissionService::createMonthlyCommission(\Carbon::now()->subMonth()->startOfMonth()->startOfDay(),
            \Carbon::now()->subMonth()->endOfMonth()->endOfDay(),
            $this);

        if ( !$result ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        return redirect()->action('BackendController@getMonthlyCommissionHistory');
    }

    public function getMonthlyCommissionHistory ($paging = 10)
    {
        $keyword = '';

        if ( \Request::has('q') ) {
            $keyword = \Request::get('q');
        }
        $monthly_commissions = \CommissionService::monthlyCommissionApproved($keyword);
        $monthly_commissions = $monthly_commissions->paginate($paging);

        return view('backend.monthly-commissions.history', [
            'title'               => 'ประวัติรายการส่วนแบ่งรายเดือน',
            'monthly_commissions' => $monthly_commissions,
            'keyword'             => $keyword,
            'paging'              => $paging
        ]);
    }
    /*
     * OrderListener Implement function
     */


    /**
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function onUpdatePaymentComplete ($message = '')
    {
        return redirect()->back()->with([ 'message' => $message ]);
    }

    public function onCancelPaymentComplete ($message = '')
    {
        return redirect()->back()->with([ 'message' => $message ]);
    }

    public function onResetPaymentComplete ($message = '')
    {
        return redirect()->back()->with([ 'message' => $message ]);
    }

    public function onUpdatePaymentFail ($message = '')
    {
        return redirect()->back()->withErrors([ $message ]);
    }

    public function onCancelPaymentFail ($message = '')
    {
        return redirect()->back()->withErrors([ $message ]);
    }

    public function onResetPaymentFail ($message = '')
    {
        return redirect()->back()->withErrors([ $message ]);
    }

    public function onOrderNotFound ()
    {
        return redirect()->back()->withError([ 'ไม่พบข้อมูลการสั่งซื้อ' ]);
    }

    public function onUserNotFound ()
    {
        return redirect()->back()->withError([ 'ไม่พบข้อมูลผู้ใช้นี้' ]);
    }

    public function onAdminNotFound ()
    {
        return redirect()->back()->withErrors([ 'ไม่พบข้อมูลผู้ดูแลระบบ' ]);
    }

    public function onAdminUpdated ()
    {
        return redirect()->action('BackendController@getAdmin')->with([ 'message' => 'อัพเดทข้อมูลเรียบร้อย' ]);
    }

    public function onAdminUpdateError ()
    {
        return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
    }

    public function onAdminCreateComplete ()
    {
        return redirect()->action('BackendController@getAdmin')->with([ 'message' => 'บันทึกข้อมูลผู้ดูแลระบบเรียบร้อยแล้ว' ]);
    }

    public function onAdminCreateError ()
    {
        return redirect()->back()->withErrors([ 'การบันทึกข้อมูลผิดพลาดกรุณาลองใหม่' ])->withInput();
    }

    public function onAssociateNotFound ($message)
    {
        return redirect()->back()->withErrors($message);
    }

    public function onAssociateUpdateComplete ($message)
    {
        return redirect()->action('BackendController@getAssociate')->with([ 'message' => $message ]);
    }

    public function onAssociateUpdateError ($message)
    {
        return redirect()->back()->withErrors($message);
    }

    public function onReturnOrderComplete ($message = '')
    {
        return redirect()->back()->with(['message' => $message]);
    }

    public function onReturnOrderFail ($message = '')
    {
        return redirect()->back()->withErrors([$message]);
    }

    public function onUpdateOrderFail ($message)
    {
        return redirect()->back()->withErrors([$message]);
    }

    public function onUpdateOrderComplete ($message)
    {
        return redirect()->back()->with(['message' => $message]);
    }
}
