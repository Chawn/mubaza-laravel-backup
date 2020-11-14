<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 9/4/2015 AD
 * Time: 14:05
 */

namespace App\Http\Controllers;

use App\AssociateStatus;
use App\Campaign;
use App\CampaignCategory;
use App\Http\Requests\AssociateRegisterInformationRequest;
use App\Http\Requests\Auth\AssociateRegisterRequest;
use App\NotificationType;
use App\UserActivate;
use App\UserBankAccount;
use Auth;

class AssociateController extends Controller
{
    public function __construct ()
    {
        $this->middleware('userauth', [
            'except' => [
                'getIndex',
                'getAffiliate',
                'getCreator',
                'getRegister',
                'postRegister',
                'getEvent'
            ]
        ]);
        $this->middleware('associate.only', [
            'except' => [
                'getIndex',
                'getEvent',
                'getCreator',
                'getAffiliate',
                'getRegister',
                'postRegister',
                'getActivate',
                'postActivate',
                'getRegisterInformation',
                'postRegisterInformation',
                'getRegisterAffiliate',
                'postRegisterAffiliate',
                'getRegisterArtist',
                'postRegisterArtist',
                'postSendOtp'
            ]
        ]);
    }

    public function getIndex ()
    {
        if ( \Auth::user()->check() && \Auth::user()->user()->isAssociate() ) {
            if(\Auth::user()->user()->affiliate->status->name == AssociateStatus::ACTIVE) {
                return view('manager.index', [
                    'title' => 'แดชบอร์ด',
                ]);
            }

            return view('errors.user-banned');
        } else {
            \Session::set('return_page', \Request::path());
            return view('manager.associate', [
                'title' => 'Associate',
            ]);
        }

    }

    public function getEvent ($name)
    {
        $view = 'manager.event-' . $name;
        return view($view, [
            'title' => '',
        ]);

    }

    public function getAffiliate ()
    {
        return view('manager.associate-affiliate', [
            'title' => 'Affiliate'
        ]);
    }

    public function getCreator ()
    {
        return view('manager.associate-artist', [
            'title' => 'Creator (ครีเอเตอร์)'
        ]);
    }

    public function getDesign ()
    {
        $campaigns = Campaign::where('user_id', Auth::user()->user()->id)
            ->whereHas('products', function () {
            })->orderBy('created_at','DESC')->paginate(20);
        return view('manager.design', [
            'title'     => 'สินค้าที่ฉันออกแบบ',
            'campaigns' => $campaigns
        ]);
    }

    public function getDownloadTemplate ()
    {
        return view('manager.design', [
            'title' => 'ดาวน์โหลด Template',
        ]);
    }

    public function getCollection ()
    {
        $collections = \Auth::user()->user()->collections()->paginate(20);

        return view('manager.collection', [
            'title'       => 'คอลเล็คชั่น',
            'collections' => $collections
        ]);
    }

    public function getCollectionDetail ()
    {
        $campaigns = Campaign::where('user_id', Auth::user()->user()->id)
            ->whereHas('products', function () {
            })->paginate(20);

        return view('manager.collection-detail', [
            'title'     => 'คอลเล็คชั่น',
            'sub_title' => 'จัดการคอลเล็คชั่น',
            'campaigns' => $campaigns
        ]);
    }

    public function getWidget ()
    {
        $campaigns = Campaign::where('user_id', Auth::user()->user()->id)
            ->whereHas('products', function () {
            })->paginate(20);

        return view('manager.widget', [
            'title'     => 'วิดเจ็ต',
            'campaigns' => $campaigns
        ]);
    }

    public function getManagerLogin ()
    {
        return view('manager.login', [
            'title' => 'เข้าสู่ระบบ',
        ]);
    }

    public function getCurrentCommission ()
    {
        $user = \Auth::user()->user();
        $monthly_commissions = $user->monthly_commissions()->approved()->orderBy('id', 'dsc')->get();

        if ( $monthly_commissions->count() <= 0 ) {
            return view('manager.commissions.current', [
                'title'               => 'รายได้ปัจจุบัน',
                'user'                => $user,
                'diff_month'          => 1,
                'monthly_commissions' => [ ]
            ]);
        }

        $latest_month = $monthly_commissions->first()->start;
        $diff_month = \Carbon::now()->diffInMonths($latest_month);
        $current_month_start = \Carbon::now()->startOfMonth()->startOfDay();
        $current_month_end = \Carbon::now()->endOfMonth()->endOfDay();
        $pending_affiliate_commission = $user->monthly_commissions()->sum('affiliate_commission');
        $pending_creator_commission = $user->monthly_commissions()->sum('creator_commission');

        return view('manager.commissions.current', [
            'title'                        => 'รายได้ปัจจุบัน',
            'user'                         => $user,
            'monthly_commissions'          => $monthly_commissions,
            'current_month_start'          => $current_month_start,
            'current_month_end'            => $current_month_end,
            'pending_affiliate_commission' => $pending_affiliate_commission,
            'pending_creator_commission'   => $pending_creator_commission,
            'latest_month'                 => $latest_month,
            'diff_month'                   => $diff_month
        ]);
    }

    public function getPaymentRequest ()
    {
        $first_of_month = \Carbon::now()->firstOfMonth();
        $diff_days = \Carbon::today()->diffInDays($first_of_month);

        return view('manager.payment-request', [
            'title'          => 'รายได้ปัจจุบัน',
            'first_of_month' => $first_of_month,
            'diff_days'      => $diff_days,
            'affiliate'      => \Auth::user()->user()->affiliate
        ]);
    }

    public function getCommissionDetail ()
    {
        if ( !\Request::has('start') || !\Request::has('end') ) {
            abort(404);
        }

        $start = \Carbon::createFromFormat('d/m/Y', \Request::get('start'))->startOfDay();
        $end = \Carbon::createFromFormat('d/m/Y', \Request::get('end'))->endOfDay();
        $detail = \CommissionService::commissionDetail(\Auth::user()->user(), $start, $end);
        return view('manager.commissions.commission-detail', [
            'title'                      => 'รายละเอียดการแบ่งรายได้ ประจำเดือน ' . $start->format('F Y'),
            'items'                      => $detail[ 'items' ],
            'start'                      => $start,
            'end'                        => $end,
            'total_affiliate_commission' => $detail[ 'total_affiliate_commission' ],
            'total_creator_commission'   => $detail[ 'total_creator_commission' ]
        ]);
    }

    public function getPaymentHistory ()
    {
        return view('manager.payment-history', [
            'title' => 'ประวัติการรับรายได้',
        ]);
    }

    public function getDesignHandbook ()
    {
        return view('manager.message', [
            'title' => 'ข้อความแจ้งเตือน',
        ]);
    }

    public function getAffiliateHandbook ()
    {
        return view('manager.message', [
            'title' => 'ข้อความแจ้งเตือน',
        ]);
    }

    public function getFAQ ()
    {
        return view('manager.message', [
            'title' => 'ข้อความแจ้งเตือน',
        ]);
    }

    public function getMessage ()
    {
        return view('manager.message', [
            'title' => 'ข้อความแจ้งเตือน',
        ]);
    }

    public function getSellReport ()
    {
        $campaigns = \Auth::user()->user()->campaigns()->paginate(20);
        return view('manager.commissions.sell-report', [
            'title'     => 'รายงานยอดขาย Creator',
            'campaigns' => $campaigns
        ]);
    }

    public function getAffiliateReport ()
    {
        $start = \Carbon::now()->startOfMonth()->startOfDay();
        $end = \Carbon::now()->endOfMonth()->endOfDay();

        if ( \Request::has('start') && \Request::has('end') ) {
            $start = \Carbon::createFromFormat('Y-m-d', \Request::get('start'))->startOfDay();
            $end = \Carbon::createFromFormat('Y-m-d', \Request::get('end'))->endOfDay();
        }

        $order_items = \CommissionService::allApprovedItem(\Auth::user()->user(), $start, $end);
        $order_items = $order_items->orderBy('approved_at', 'dsc');

        $order_items = $order_items->paginate(20);
        return view('manager.commissions.affiliate-report', [
                'title'       => 'รายงานยอดขายของ Affiliate ของวันที่ ' . $start->format('j/n/Y') . ' ถึง ' . $end->format('j/n/Y'),
                'order_items' => $order_items,
                'start'       => $start,
                'end'         => $end
            ]
        );
    }

    public function getProfileSetting ()
    {
        return view('manager.profile-setting', [
            'title' => 'โปรไฟล์',
        ]);
    }

    public function getBankAccount ()
    {
        $user = \Auth::user()->user();

        return view('manager.bank-account', [
            'title' => 'บัญชีธนาคาร',
            'user'  => $user
        ]);
    }

    public function getEditCampaignSample ()
    {
        return view('manager.edit-campaign', [
            'title' => 'แก้ไขสินค้า',
        ]);
    }

    public function postUpdateSellPrice ($campaign_id)
    {
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลแคมเปญ' ]);
        }

        if ( !$campaign->updateSellPrice(\Request::get('data')) ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่สมารถบันทึกข้อมูลได้' ]);
        }

        return response()->json([ 'success' => true, 'message' => 'บันทึกข้อมูลเสร็จเรียบร้อย' ]);
    }

    public function getCreate ()
    {
        return view('manager.design.create', [
            'title'     => 'สร้างสินค้าใหม่',
            'sub_title' => 'อัพโหลดลาย',
        ]);
    }

    public function getEditCampaign ($campaign_id)
    {
        $campaign = Campaign::with([
            'products' => function ($q) {
                $q->where('is_deleted', false);
            }
        ])->where('id', $campaign_id)->first();

        if ( !$campaign ) {
            return redirect()->back()->withErrors([ 'ไม่พบแคมเปญที่ต้องการ' ]);
        }
        $categories = CampaignCategory::where('is_active', true)->get([ 'id', 'name', 'detail' ]);
        return view('manager.edit-campaign', [
            'title'      => 'แก้ไขแคมเปญ',
            'sub_title'  => $campaign->title,
            'categories' => $categories,
            'campaign'   => $campaign
        ]);
    }

    /**
     * Add product view
     *
     * @param $campaign_id
     * @return $this|\Illuminate\View\View
     */
    public function getAddProduct ($campaign_id)
    {
        $campaign = Campaign::whereId($campaign_id)->select('id')->first();
        if ( !$campaign ) {
            return redirect()->back()->withErrors([ 'ไม่พบแคมเปญ' ]);
        }

        return view('manager.add-product', [
            'title'       => 'เพิ่มสินค้า',
            'sub_title'   => 'เพิ่มสินค้า',
            'campaign_id' => $campaign->id
        ]);
    }

    public function getStep1 ()
    {
        return view('manager.design.step1', [
            'title'     => 'สร้างสินค้าใหม่',
            'sub_title' => 'อัพโหลดลาย',
        ]);
    }

    public function postUpload ()
    {
        $inputs = \Request::all();


        if ( !\Request::hasFile('image') ) {
            return response()->json([
                'result'  => false,
                'message' => 'ไม่พบข้อมูลไฟล์ที่อัพโหลด'
            ]);
        }

        $mime_type = [ 'image/png', 'image/x-png' ];
        $mime = $inputs[ 'image' ]->getMimeType();

        if ( !in_array($mime, $mime_type) ) {
            return response()->json([
                'result'  => false,
                'message' => 'อนุญาติให้อัพโหลดเฉพาะไฟล์รูปภาพแบบ PNG เท่านั้น'
            ]);
        }

        if ( !$inputs[ 'image' ]->isValid() ) {
            return response()->json([
                'result'  => false,
                'message' => 'มีความเสียหายของข้อมูลกรุณาอัพใหม่'
            ]);
        }

        if ( $inputs[ 'image' ]->getSize() > 5242880 ) {
            return response()->json([
                'result'  => false,
                'message' => 'ขนาดไฟล์สูงสุดต้องไม่เปิน 5 mb'
            ]);
        }

        $ext = $inputs[ 'image' ]->getClientOriginalExtension();

        $path = 'upload' . date('dmY');

        $name = 'picture' . uniqid() . '.' . $ext;

        $full_path = $path . '/' . $name;

        \Storage::makeDirectory($path);

        if ( !\Storage::disk('local')->put('tmp/' . $full_path, \File::get($inputs[ 'image' ])) ) {
            return response()->json([
                'result'  => false,
                'message' => 'ไม่สามารถบันทึกรูปภาพได้กรุณาลองใหม่'
            ]);
        }

        // TODO : Intervention Image require edit memory_limit in php.ini for more memory consume
        $img = \Image::make('../storage/app/tmp/' . $full_path);

        $width = $img->getWidth();
        $height = $img->getHeight();

        if ( !\ImageService::checkSize('../storage/app/tmp/' . $full_path,
            config('constant.image_size.art.max_width'),
            config('constant.image_size.art.max_height'), 0, 0, true)
        ) {

            return response()->json([
                'result'  => false,
                'message' => 'รูปภาพไม่ตรงตามขนาดที่กำหนดไว้คือ ต้องมีความกว้างไม่น้อยกว่า '
                    . config('constant.image_size.art.max_width')
                    . ' พิกเซล และ สูงไม่น้อยกว่า '
                    . config('constant.image_size.art.max_height') . ' พิกเซล'
            ]);
        }

        $img->resize(200, NULL, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save('../storage/app/tmp/' . $path . '/thmb_' . $name);

        $file = [
            'full_path' => action('AssociateController@getTempFile', [ $path, $name ]),
            'path'      => 'tmp/' . $path,
            'file_name' => [
                'large'     => $name,
                'thumbnail' => 'thmb_' . $name
            ]
        ];
        return response()->json([
            'result' => true,
            'file'   => $file
        ]);
    }

    public function postUploadShirt ()
    {
        $inputs = \Request::all();

        if ( !\Request::hasFile('image') ) {
            return response()->json([
                'result'  => false,
                'message' => 'ไม่พบข้อมูลไฟล์ที่อัพโหลด'
            ]);
        }

        $mime_type = [ 'image/jpg', 'image/jpeg' ];
        $mime = $inputs[ 'image' ]->getMimeType();

        if ( !in_array($mime, $mime_type) ) {
            return response()->json([
                'result'  => false,
                'message' => 'อนุญาติให้อัพโหลดเฉพาะไฟล์รูปภาพแบบ JPG เท่านั้น'
            ]);
        }

        if ( !$inputs[ 'image' ]->isValid() ) {
            return response()->json([
                'result'  => false,
                'message' => 'มีความเสียหายของข้อมูลกรุณาอัพใหม่'
            ]);
        }

        if ( $inputs[ 'image' ]->getSize() > 5242880 ) {
            return response()->json([
                'result'  => false,
                'message' => 'ขนาดไฟล์สูงสุดต้องไม่เปิน 5 mb'
            ]);
        }
        $extension = $inputs[ 'image' ]->getClientOriginalExtension();

        $path = 'upload' . date('dmY');

        $name = 'picture' . uniqid() . '.' . $extension;

        $full_path = $path . '/' . $name;

        if ( !\ImageService::upload($inputs[ 'image' ], 'tmp/' . $path, $name) ) {
            return response()->json([
                'result'  => false,
                'message' => 'ไม่สามารถบันทึกรูปภาพได้กรุณาลองใหม่'
            ]);
        }

        if ( !\ImageService::checkSize('../storage/app/tmp/' . $full_path,
            config('constant.image_size.shirt.max_width'),
            config('constant.image_size.shirt.max_height'),
            config('constant.image_size.shirt.min_width'),
            config('constant.image_size.shirt.min_height')
        )
        ) {
            return response()->json([
                'result'  => false,
                'message' => 'รูปภาพไม่ตรงตามขนาดที่กำหนดไว้คือ ต้องมีความกว้างไม่น้อยกว่า '
                    . config('constant.image_size.shirt.min_width') . ' พิกเซล และ สูงไม่น้อยกว่า '
                    . config('constant.image_size.shirt.min_height') . ' พิกเซล'
            ]);
        }

        $file = [
            'full_path' => action('AssociateController@getTempFile', [ $path, $name ]),
            'path'      => 'tmp/' . $path,
            'file_name' => [
                'large' => $name
            ]
        ];
        return response()->json([
            'result' => true,
            'file'   => $file
        ]);
    }

    public function getTempFile ($path, $file_name)
    {
        $file_name_array = explode('.', $file_name);
        $ext = last($file_name_array);

        $file = \Storage::get('tmp/' . $path . '/' . $file_name);

        $mime_type = '';

        if($ext == 'png') {
            $mime_type = 'image/png';
        } elseif($ext == 'jpg') {
            $mime_type = 'image/jpeg';
        }
        return response()->make($file, 200, ['content-type' => $mime_type]);
    }

//    public function postSaveCollection ()
//    {
//        $inputs = \Request::all();
//        $cover_image = '';
//
//        $collection = new Collection();
//
//        $collection->name = $inputs[ 'name' ];
//        $collection->url = Collection::createUrl($inputs[ 'name' ]);
//        $collection->detail = $inputs[ 'detail' ];
//        $collection->private = $inputs[ 'private' ];
//        $collection->user_id = $inputs[ 'user_id' ];
//        if ( !$collection->save() ) {
//            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
//        }
//
//        if ( !\Request::hasFile('cover_image') ) {
//            return redirect()->action('AssociateController@getCollection')->with([ 'message' => 'บันทึกข้อมูลคอลเลคชั่นแล้ว' ]);
//        }
//
//        $mime_type = [ 'image/png', 'image/x-png', 'image/jpg', 'image/jpeg' ];
//        $mime = $inputs[ 'cover_image' ]->getMimeType();
//
//        if ( !$inputs[ 'image' ]->isValid() ) {
//            return redirect()->back()->withErrors([ 'มีความเสียหายของข้อมูลกรุณาอัพใหม่' ]);
//        }
//        if ( !in_array($mime, $mime_type) ) {
//            return redirect()->back()->withErrors([ 'อนุญาติให้อัพโหลดเฉพาะไฟล์รูปภาพแบบ PNG หรือ JPEG เท่านั้น' ]);
//        }
//
//        if ( $inputs[ 'cover_image' ]->getSize() > 5242880 ) {
//            return redirect()->back()->withErrors([ 'ขนาดไฟล์สูงสุดต้องไม่เปิน 5 mb' ]);
//        }
//
//        $ext = $inputs[ 'cover_image' ]->getClientOriginalExtension();
//
//        $path = 'images/collection/' . str_pad($collection->id, 6, 0, STR_PAD_LEFT);
//
//        $name = 'picture' . uniqid() . '.' . $ext;
//
//        $full_path = $path . '/' . $name;
//
//        \Storage::makeDirectory($path);
//
//        if ( !\Storage::disk('local')->put($full_path, \File::get($inputs[ 'cover_image' ])) ) {
//            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกรูปภาพได้กรุณาลองใหม่' ]);
//        }
//
//        $cover_image = $name;
//        $collection->cover_image = $cover_image;
//
//        if ( !$collection->save() ) {
//            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลภาพหน้าปกได้' ]);
//        }
//
//        return redirect()->action('AssociateController@getCollection')->with([ 'message' => 'บันทึกมูลเรียบร้อย' ]);
//    }

    public function getRegister ()
    {
        if ( \Auth::user()->check() ) {
            if ( \Auth::user()->user()->isAssociate() ) {
                return redirect()->action('AssociateController@getDesign');
            }
            return redirect()->action('AssociateController@getRegisterInformation');
        }

        return view('manager.register.index', [
            'title' => 'ลงทะเบียน Associate'
        ]);
    }

    public function postRegister (AssociateRegisterRequest $request)
    {
        $user = \Auth::user()->user();
        $inputs = $request->except('_token');
        $user->full_name = $inputs[ 'full_name' ];
        $user->email = $inputs[ 'email' ];
        $user->password = bcrypt($inputs[ 'password' ]);
        $user->profile()->update([ 'phone' => $inputs[ 'phone' ] ]);

        if ( !$user->save() ) {
            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);
        }

        return redirect()->action('AssociateController@getRegisterInformation');
    }

    public function getRegisterInformation ()
    {
        $user = \Auth::user()->user();
        if ( $user->isAssociate() ) {
            return redirect()->action('AssociateController@getIndex');
        }

        return view('manager.register.information', [
            'title' => 'ข้อมูล Associate',
            'user'  => \Auth::user()->user()
        ]);
    }

    public function postRegisterInformation (AssociateRegisterInformationRequest $request)
    {
        $user = \Auth::user()->user();
        \DB::beginTransaction();

        $user->full_name = \Request::get('full_name');
        $user->username = \Request::get('username');
        $user->email = \Request::get('email');
        $user->detail = \Request::get('detail');
        $user->profile()->update(\Request::only([
            'address', 'building', 'district', 'province', 'zipcode', 'phone'
        ]));

        if ( \Request::hasFile('avatar') ) {
            $file = \Request::file('avatar');
            if ( !$file->isValid() ) {
                \DB::rollback();
                return redirect()->back()->withErrors([ 'การอัพโหลดข้อมูลไม่สำเร็จกรุณาลองใหม่' ])->withInput();
            }
            $mime_type = [ 'image/png', 'image/x-png', 'image/jpg', 'image/jpeg' ];
            $mime = $file->getMimeType();

            if ( !$file->isValid() ) {
                \DB::rollback();
                return redirect()->back()->withErrors([ 'มีความเสียหายของข้อมูลกรุณาอัพใหม่' ]);
            }
            if ( !in_array($mime, $mime_type) ) {
                \DB::rollback();
                return redirect()->back()->withErrors([ 'อนุญาติให้อัพโหลดเฉพาะไฟล์รูปภาพแบบ PNG หรือ JPEG เท่านั้น' ]);
            }

            if ( $file->getSize() > 5242880 ) {
                \DB::rollback();
                return redirect()->back()->withErrors([ 'ขนาดไฟล์สูงสุดต้องไม่เปิน 5 mb' ]);
            }
            $ext = $file->getClientOriginalExtension();

            $path = 'images/users/' . str_pad($user->id, 6, 0, STR_PAD_LEFT);

            $name = 'profile-' . uniqid() . '.' . $ext;

            $full_path = $path . '/' . $name;

            \Storage::makeDirectory($path);

            if ( !\Storage::disk('local')->put($full_path, \File::get($file)) ) {
                \DB::rollback();
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกรูปภาพได้กรุณาลองใหม่' ])->withInput();
            }

            $user->avatar = $name;
        }

        if ( !$user->createAssociate() ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้กรุณาลองใหม่' ])->withInput();
        }
        if ( !$user->save() ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกข้อมูลได้' ]);
        }

        \DB::commit();

        return redirect()->action('AssociateController@getComplete');
    }

    public function getActivate ($type)
    {
        return view('manager.register.activate', [
            'title' => 'ยืนยันตัวตน',
            'type'  => $type
        ]);
    }

    public function postSendOtp ()
    {
        $user = \Auth::user()->user();
        $user->clearOtp();
        $user_activate = UserActivate::createOTP($user);

        if ( !$user_activate ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่สามารถสร้างรหัส OTP ได้' ]);
        }

        return response()->json([ 'success' => true, 'ref_no' => $user_activate->id ]);
    }

//    public function postActivate ($type)
//    {
//        if ( !\Request::has('otp') ) {
//            return redirect()->back()->withErrors([ 'ไม่พบข้อมูล OTP' ])->withInput();
//        }
//        $user = \Auth::user()->user();
//        $result = UserActivate::checkOTP($user, \Request::get('otp'));
//
//        if ( !$result ) {
//            return redirect()->back()->withErrors([ 'รหัส OTP ของคุณไม่ถูกต้อง' ])->withInput();
//        }
//
//        if ( !$user->changeType($type) ) {
//            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ])->withInput();
//        }
//        return redirect()->action('AssociateController@getComplete', $type);
//
//    }

    public function getComplete ()
    {
        return view('manager.register.complete', [
            'title' => 'การลงทะเบียนสำเร็จแล้ว'
        ]);
    }

    public function getGenerateLink ()
    {
        return view('manager.affiliates.generate-link', [
            'title' => 'สร้างลิงค์สินค้า'
        ]);
    }

    public function postGenerateLink ()
    {
        if ( !\Request::has('url') ) {
            return response()->json([ 'success' => false, 'message' => 'ข้อมูล URL ว่างเปล่า' ]);
        }
        $url = \Request::get('url');
        $extracted_url = collect(explode('/', $url));

        $campaign_url = explode('.', $extracted_url->last());

        if ( count($campaign_url) <= 0 ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบ URL กรุณาลองใหม่' ]);
        }

        $campaign = Campaign::whereUrl(rawurldecode($campaign_url[0]))->first();

        if ( !$campaign ) {
            return response()->json([ 'success' => false, 'message' => 'ไม่พบข้อมูลสินค้ากรุณาลองใหม่' ]);
        }

        $affiliate = \Auth::user()->user()->affiliate;
        $affiliate_link = $campaign->affiliateLink($affiliate);
        $affiliate_iframe_url = $campaign->affiliateIframe($affiliate);
        $affiliate_iframe_code = html_entity_decode('<iframe src="' . $affiliate_iframe_url . '" width="300" height="426"></iframe>');
        return response()->json([
            'success'               => true,
            'affiliate_link'        => $affiliate_link,
            'affiliate_iframe_url'  => $affiliate_iframe_url,
            'affiliate_iframe_code' => $affiliate_iframe_code
        ]);
    }

    public function postBankAccount ()
    {
        $user = \Auth::user()->user();
        $inputs = \Request::except('_token');


        if($user->bank_account ) {
            $user->bank_account()->update($inputs);
        } else {
            $user->bank_account()->create($inputs);
        }

        if ( !$user->save() ) {
            return redirect()->back()->withErrors([ 'การบันทึกข้อมูลเกิดข้อผิดพลาด' ]);
        }

        \NotificationService::create(
            $user->id,
            NotificationType::ASSOCIATE,
            'คุณได้ทำการเปลี่ยนเลขที่บัญชีแล้วคลิ๊กเพื่อดูรายละเอียด',
            action('AssociateController@getBankAccount'
            ));
        return redirect()->back()->with([ 'message' => 'การบันทึกกข้อมูลเสร็จเรียบร้อย' ]);
    }

    public function postUpdateMinimumCommission ($affiliate_id)
    {
        if(!\Request::has('minimum_commission')) {
            return redirect()->back()->withErrors(['ไม่มีข้อมูลจำนวนเงิน']);
        }

        if(!\CommissionService::updateMinimumCommission($affiliate_id, \Request::get('minimum_commission'))) {
            return redirect()->back()->withErrors(['ไม่สามารถบันทึกข้อมูลได้']);
        }

        return redirect()->back()->with(['message' => 'บันทึกข้อมูลยอดเงินขั้นต่ำเรียบร้อยแล้ว']);
    }
}