<?php namespace App\Http\Controllers;

use App\Affiliate;
use App\CampaignTag;
use App\Report;
use App\Tag;
use Auth;
use App\User;
use App\UserProfile;
use App\Campaign;
use Request;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct ()
    {
//		$this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index ()
    {
//        $recommends = Campaign::where('is_recommended', true)->orderBy('created_at','desc')->take(12)->get();
//        $hots = Campaign::where('is_hot', true)->orderBy('created_at','desc')->take(16)->get();
        $recommends = \CampaignService::recommended(12);
        $hots = \CampaignService::hot(12);

        $latest_view_campaigns = [];

        if(\Cookie::has('last_viewed')) {
            $last_vieweds = \Cookie::get('last_viewed');

            $latest_view_campaigns = Campaign::whereIn('id', $last_vieweds->pluck('id')->toArray())->get();
        }

        /*$campaigns = Campaign::whereHas('products', function ($q) {
        })->paginate(16);*/
        return view('new-index', [
            'title'     => 'Mubaza | Shirts for Every Moment.',
            'recommends' => $recommends,
            'hots' => $hots,
            'latest_view_campaigns' => $latest_view_campaigns
        ]);
    }

    public function TestIndex ()
    {
        $campaigns = Campaign::whereHas('products', function ($q) {
        })->paginate(16);
        return view('new-index', [
            'title'     => 'Mubaza.com',
            'campaigns' => $campaigns
        ]);
    }

    public function postUpdateUserProfile ()
    {
        $inputs = Request::all();
        $user = User::find($inputs[ 'user_id' ]);
        $profile = $user->profile;
        $user->email = $inputs[ 'email' ];
        $profile->user_id = $inputs[ 'user_id' ];
        $user->full_name = $inputs[ 'full_name' ];
        $profile->address = $inputs[ 'address' ];
        $profile->district = $inputs[ 'district' ];
        $profile->province = $inputs[ 'province' ];
        $profile->zipcode = $inputs[ 'zipcode' ];

        $user->profile()->save($profile);
        $user->save();
    }

    public function postContact ()
    {
        $inputs = \Request::all();
        $full_path = '';
        if ( \Request::hasFile('file') && $inputs[ 'file' ]->isValid() ) {
            if ( $inputs[ 'file' ]->getSize() > 3145728 ) {
                return redirect()->back()->withInput()->withErrors([ 'message' => 'ขนาดไฟล์แนบต้องมีขนาดไม่เกิน 3 Mb' ]);
            }
            $ext = $inputs[ 'file' ]->getClientOriginalExtension();
            $store_directory = 'storage/contact/' . \Carbon::now()->format('dmY');
            if ( !\Storage::exists($store_directory) ) {
                \Storage::makeDirectory($store_directory);
            }

            $name = 'contact-' . uniqid() . '.' . $ext;

            if ( $inputs[ 'file' ]->move(
                $store_directory,
                $name
            )
            ) {
                $full_path = $store_directory . '/' . $name;
            }

            return redirect()->back()->withErrors([ 'message' => 'มีปัญหาในการอัพโหลดไฟล์กรุณาลองใหม่' ]);
        }

        \Mail::send('backend.mail.contact-mail', [
            'title'      => 'test',
            'data'       => $inputs,
            'image_path' => url('/') . '/' . $full_path
        ], function ($message) use ($full_path) {
            $message->to(config('constant.mubaza_email'));
            if ( $full_path != '' ) {
                $message->attach($full_path);
            }

            $message->subject('ข้อความติดต่อจากลูกค้า');
        });

        return redirect()->back()->with([ 'message' => 'ส่งข้อมูลเรียบร้อยแล้ว' ]);
    }

    public function postReport ($user_id)
    {
        $inputs = \Request::all();

        $report = Report::create([
            'report_type_id' => \App\ReportType::whereName($inputs[ 'report_type_name' ])->first()->id,
            'detail'         => \Request::has('detail') ? $inputs[ 'detail' ] : '',
            'reporter_id'    => $user_id,
            'user_id'        => \Request::has('user_id') ? $inputs[ 'user_id' ] : null,
            'campaign_id'    => \Request::has('campaign_id') ? $inputs[ 'campaign_id' ] : null
        ]);

        if ( $report ) {
            return response()->json([
                'error'   => false,
                'message' => 'บันทึกการรายงานปัญหาเรียบร้อยแล้ว'
            ]);
        }
        return response()->json([
            'error'   => true,
            'message' => 'ไม่สามารถบันทึกการรายงานปัญหาได้กรุณาลองใหม่'
        ]);
    }

    public function getProduct ($id)
    {
        $campaign = Campaign::where('id', $id)->active()->first();
        $affiliate = null;

        if ( \Request::has('affid') ) {
            $affiliate = Affiliate::find(\Request::get('affid'));
        }

        return view('iframe-product', [
            'title'     => 'สินค้า',
            'campaign'  => $campaign,
            'affiliate' => $affiliate
        ]);
    }
}