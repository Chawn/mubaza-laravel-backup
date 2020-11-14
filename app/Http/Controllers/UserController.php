<?php namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignProduct;
use App\CampaignStatus;
use App\CampaignTag;
use App\CampaignWishList;
use App\Http\Requests;
use App\Http\Requests\Auth\RegisterRequest;
use App\Order;
use App\Tag;
use App\User;
use App\UserFollow;
use App\UserProfile;
use App\UserStatus;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Socialite;
use Url;

class UserController extends Controller
{

    public function __construct ()
    {
        //Insert middlerware authenticate here
        $this->middleware('userauth', [
            'except' => [
                'getFile',
                'getProfile',
                'getAddress',
                'getContact',
                'getFollower',
                'getRegister',
                'postRegister',
                'getActivate',
                'getLogin',
                'postLogin',
                'getSocialLogin',
                'getForgotPassword',
                'postForgotPassword',
                'getResetPassword',
                'postResetPassword',
                'getComfirmEmail',
                'getIndex',
                'getCampaign',
                'getFollowing',
                'getFavorite',
                'getSignup',
                'getAbout',
                'getUserBannedError',
                'getCreatorShow'
            ]
        ]);
        $this->middleware('view_count', [ 'only' => [ 'getIndex' ] ]);
    }

    public function getIndex ($id)
    {
        $user = User::get($id);

        if ( !$user ) {
            abort(404);
        }

        if ( \Auth::user()->check() && $user->isOwner(\Auth::user()->user()->id) ) {
            $campaigns = Campaign::orderBy('end', 'desc')
                ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)
                ->whereIn('campaign_status_id', [
                    CampaignStatus::active()->first()->id,
                    CampaignStatus::close()->first()->id
                ])
                ->where('user_id', $user->id)->simplePaginate(9);
            return view('user.index', [
                'title'         => 'แดชบอร์ด',
                'user'          => $user,
                'campaigns'     => $campaigns,
                'current_route' => 'index',
            ]);
        } else {
            return redirect('/');
        }

    }

    /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function getRegister ()
    {
        if ( \Auth::user()->check() ) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function getSignup ()
    {
//        return redirect()->action('AssociateController@getRegister', 'creator');
        if ( \Auth::user()->check() ) {
            return redirect('/');
        }
        return view('auth.signup', [
            'title' => 'สมัครสมาชิกด้วยอีเมลล์',
            'current_route' => 'signup',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest $request
     * @return Response
     */
    public function postRegister (RegisterRequest $request)
    {
        \DB::beginTransaction();
        $user = new User;
        //code for registering a user goes here.
        $user->full_name = $request[ 'full_name' ];
        $user->email = $request[ 'email' ];
        $user->password = bcrypt($request[ 'password' ]);
        $user->user_status_id = UserStatus::whereName('inactive')->first()->id;
        $user->user_role_id = \App\UserRole::whereName('user')->first()->id;
        $token = $this->createNewToken($user->email);
        $user->remember_token = bcrypt($token);
        if ( !$user->save() ) {
            \DB::rollback();
            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);
        }

        $profile = new UserProfile;
        $profile->id = $user->id;
        $profile->phone = \Request::has('phone') ? $request[ 'phone' ] : '';
        $user->profile()->save($profile);
        $option = new \App\UserOption();
        $option->id = $user->id;
        $option->save();
        \DB::commit();
        \SendMail::sendConfirmRegistration($user, $token);

        \Auth::user()->login($user);
        if ( \Request::has('return') ) {
            return redirect(\Request::get('return'));
        } else {
            return redirect('/');
        }
    }

    public function getLogin ()
    {
        if ( \Auth::user()->check() ) {
            return redirect('/');
        }

        $inputs = \Request::all();

        session([
            'return_page' => \URL::previous()
        ]);
        return view('auth.login', [ 
            'title' => 'เข้าสู่ระบบ' ,
            'current_route' => 'login',
        ]);
    }

    public function postLogin ()
    {
        $inputs = \Request::all();
        if ( \Auth::user()->attempt([ 'email' => $inputs[ 'email' ], 'password' => $inputs[ 'password' ] ]) ) {
            if ( \Auth::user()->user()->isActive() ) {
                $url = session('return_page');
                \Session::forget('return_page');
//                $url = URL::previous();
                return redirect($url);
            }

            \Auth::user()->logout();
            return 'User Banned';
        } else {
            \Log::warning('Login failed From IP : ' . \Request::getClientIp());
        }


        return redirect('/login')->withErrors([
            'email' => 'อีเมล์ และรหัสผ่าน ไม่ตรงกัน',
        ]);
    }

    public function getSocialLogin (Request $request, $provider)
    {
        if(\Request::has('return')) {
            \Session::set('return_page', \Request::get('return'));
        }
        if ( $request->has('code') || $request->has('oauth_token') ) {
            $social_user = Socialite::with($provider)->user();
            $user = User::where('email', '=', $social_user->email)->first();

            if ( !$user ) {
                $user = User::firstOrCreate([
                    'full_name'      => $social_user->name,
                    'username'       => $social_user->nickname,
                    'email'          => $social_user->email,
                    'avatar'         => $social_user->avatar,
                    'is_social'      => 1,
                    'provider'       => $provider,
                    'user_status_id' => UserStatus::whereName('normal')->first()->id,
                    'user_role_id'   => \App\UserRole::whereName('user')->first()->id
                ]);

                if ( $user ) {
                    $profile = UserProfile::firstOrCreate([
                        'id'       => $user->id,
                        'birthday' => null
                    ]);
                    $option = \App\UserOption::firstOrCreate([
                        'id' => $user->id
                    ]);
                }
            }
            Auth::user()->loginUsingId($user->id);

            if ( !\Auth::user()->check() ) {
                return redirect()->action('UserController@getLogin')->withErrors([ 'ไม่สามารถเข้าสู่ระบบได้' ]);
            }

            if(\Auth::user()->user()->status->name == 'banned') {
                \Auth::user()->logout();
                return view('errors.user-banned');
            }
            $url = session('return_page');

            if ( !$url ) {
                $url = '/';
            }
            return redirect($url);
        }

        return Socialite::with($provider)->redirect();
    }

    public function getLogout ($id)
    {
        if ( \Auth::user()->check() ) {
            \Auth::user()->logout();
        }
        $url = \URL::previous();
        return redirect($url);
    }

    public function getUserBannedError ()
    {
        return view('errors.user-banned');
    }
    public function getForgotPassword ()
    {
        return view('auth.forgetpassword', [
            'title' => 'ตัวช่วยการลืมรหัส' ,
            'current_route' => 'forgot-password',
        ]);
    }

    public function postForgotPassword ()
    {
        $recaptcha = new \ReCaptcha\ReCaptcha('6LcTwwoTAAAAAKLd4RWwnnucLbNFm3yA-PWH7JWx');
        $inputs = \Request::all();
        $resp = $recaptcha->verify($inputs[ 'g-recaptcha-response' ], \Request::ip());

        if ( !$resp->isSuccess() ) {
            return redirect()->back()->withErrors('รหัสยืนยันตัวตนไม่ถูกต้อง');
        }
        $email = $inputs[ 'email' ];
        $user = User::whereEmail($email)->first();
        if ( !$user ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลผู้ใช้งานกรุณาลองใหม่' ]);
        }

        // Send email with remember_token
        $token = $this->createNewToken($user->email);
        $user->remember_token = bcrypt($token);
        $user->update();

        if ( !\SendMail::sendReminderEmail($user, $token) ) {
            return redirect()->back()->withErrors([ 'ไม่สามารถดำเนินการส่งอีเมล์ได้กรุณาลองใหม่' ]);
        }
        return view('auth.reminder-sent', [
            'title' => 'การกูคืนรหัสผ่านเสร็จเรียบร้อย'
        ]);
    }

    function createNewToken ($email)
    {
        $value = str_shuffle(sha1($email . spl_object_hash($this) . microtime(true)));

        return hash_hmac('sha1', $value, config('app.key'));
    }

//    function sendReminderEmail ($user, $token)
//    {
//        \Mail::send('backend.mail.resetpassword', [
//            'user' => $user, 'token' => $token, 'id' => $user->getID()
//        ], function ($m) use ($user) {
//            $m->to($user->email, $user->name)->subject('ยืนยันการเปลี่ยนรหัสผ่าน');
//        });
//    }

//    function sendConfirmationEmail ($user, $token)
//    {
//        \Mail::send('backend.mail.regis', [
//            'user' => $user, 'token' => $token, 'id' => $user->getID()
//        ], function ($m) use ($user) {
//            $m->to($user->email, $user->name)->subject('ยินยันการสมัครสมาชิก เว็บไซต์​ Mubaza.com');
//        });
//    }

//    function sendRegisterComplete ($user)
//    {
//        \Mail::send('backend.mail.registered', [ 'user' => $user ], function ($m) use ($user) {
//            $m->to($user->email, $user->name)->subject('การสมัครสมาชิกเสร็จเรียบร้อย');
//        });
//    }

    function sendPasswordChanged ($user_id, $token)
    {
        $user = User::find($user_id);
        if ( $user ) {
            \Mail::send('backend.mail.password-reset', [
                'user'    => $user,
                'send_on' => \Date::now()->format('l j F Y H:i:s'),
                'token'   => $token,
                'id'      => $user->getID()
            ], function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('คุณได้ทำการเปลี่ยนรหัสผ่านของคุณ');
            });
        }
    }

    function sendEmailChanged ($user, $token, $email)
    {
        \Mail::send('backend.mail.new-email', [
            'user'      => $user,
            'send_on'   => \Date::now()->format('d F Y H:i'),
            'token'     => $token,
            'old_email' => $email,
            'id'        => $user->getID()
        ],
            function ($m) use ($user, $email) {
                $m->to($email, $user->name)->subject('คุณได้ทำการเปลี่ยนอีเมล์ของคุณ');
            });
    }

    public function getComfirmEmail ($id, $token)
    {
        $user = User::get($id);

        if ( $user ) {
            return 'User not found';
        }

        if ( $user->status->name == 'normal' ) {
            return 'คุณได้ทำการยืนยันชื่อผู้ใช้นี้แล้ว';
        }

        if ( !Hash::check($token, $user->remember_token) ) {
            return 'รหัสความปลอดภัยไม่ตรงกัน';
        }

        $this->sendRegisterComplete($user);
        $user->status()->associate(UserStatus::whereName('normal')->first());
        if ( $user->save() ) {
            \Auth::user()->loginById($user->id);
            return redirect(url('/'));
        }

        return 'ไม่สามารถบันทึกข้อมูลได้';

    }

    public function getResetPassword ($id, $token)
    {
        $user = User::get($id);

        if ( !$user ) {
            \View::share('title', 'ไม่พบข้อมูลที่ต้องการ');
            return abort(404);
        }
        if ( !Hash::check($token, $user->remember_token) ) {
            \View::share('title', 'ไม่สามารถเข้าใช้งาน');
            return abort(403);
        }

        return view('auth.repassword', [
            'title' => 'เปลี่ยนรหัสผ่าน',
            'user'  => $user,
            'current_route' => 'profile',
        ]);

    }

    public function postResetPassword ()
    {
        $inputs = \Request::all();

        $user = User::find($inputs[ 'user_id' ]);

        if ( !$user ) {
            \View::share('title', 'ไม่พบข้อมูลที่ต้องการ');
            abort(404);
        }

        if ( $inputs[ 'password' ] != $inputs[ 'password_confirmation' ] ) {
            return redirect()->back()->withErrors([ 'message' => 'รหัสผ่านไม่ตรงกันกรุณาตรวจสอบใหม่' ]);
        }

        $user->password = bcrypt($inputs[ 'password' ]);
        $user->remember_token = '';

        if ( !$user->update() ) {
            return redirect()->back()->withErrors([ 'message' => 'การบันทึกรหัสผ่านเกิดข้อผิดพลาดกรุณาลองใหม่' ]);
        }
        return redirect()->action('HomeController@index');
    }

    public function getSecure ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        return view('user.user-account-security', [
            'title' => 'ตั้งรหัสผ่าน',
            'user'  => $user,
            'current_route' => 'profile',
        ]);

    }

    public function postChangePassword ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $inputs = \Request::all();

        if ( !(is_null($user->password) && $user->is_social) ) {
            if ( !Hash::check($inputs[ 'old_password' ], $user->password) ) {
                return redirect()->back()->withErrors([ 'รหัสผ่านผิดกรุณาลองใหม่อีกครั้ง' ]);
            }
        }

        if ( $inputs[ 'password' ] != $inputs[ 'password_confirmation' ] ) {
            return redirect()->back()->withErrors([ 'รหัสผ่านใหม่ไม่ตรงกันกรุณาลองใหม่อีกครั้ง' ]);
        }

        if ( Hash::check($inputs[ 'password' ], $user->password) ) {
            return redirect()->back()->withErrors([ 'รหัสผ่านใหม่ซำ้กับรหัสสผ่านเดิม' ]);
        }

        $user->password = bcrypt($inputs[ 'password' ]);
        $user->is_social = 0;
        $token = $this->createNewToken($user->email);
        $user->remember_token = bcrypt($token);

        if ( $user->update() ) {
            $this->sendPasswordChanged($user->id, $token);
            return redirect()->back()->with('message', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);

    }

    public function postChangeEmail ($id)
    {
        $inputs = \Request::all();
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        if ( !Hash::check($inputs[ 'password' ], $user->password) ) {
            return redirect()->back()->withErrors([ 'รหัสผ่านผิดกรุณาลองใหม่อีกครั้ง' ]);
        }

        if ( $user->email === $inputs[ 'email' ] ) {
            return redirect()->back()->withErrors([ 'อีเมล์ตรงกับอีเมล์ปัจจุบัน' ]);
        }

        if ( User::emailCheck($inputs[ 'email' ]) ) {
            return redirect()->back()->withErrors([ 'อีเมล์นี้มีผู้ใช้งานอยู่แล้วกรุณาเลือกใหม่' ]);
        }

        $old_email = $user->email;
        $token = $this->createNewToken($user->email);
        $user->email = $inputs[ 'email' ];
        $user->remember_token = bcrypt($token);
        $user->status()->associate(UserStatus::whereName('inactive')->first());
        $user->show_email = \Request::has('show_email') ? $inputs[ 'show_email' ] : 0;

        if ( $user->update() ) {
            $this->sendEmailChanged($user, $token, $old_email);
            return redirect()->back()->with('message', 'ระบบส่งข้อความไปยังอีเมล์ของคุณเพื่อยืนยันการเปลี่ยนอีเมล์');
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่' ]);

    }

    public function getActivate ($id, $token)
    {
        $user = User::find($id);

        if ( !$user ) {
            return 'Permission deny';
        }

        if ( !$user->inActive() ) {
            return 'คุณได้ทำการยืนยันชื่อผู้ใช้นี้แล้ว';
        }

        if ( !Hash::check($token, $user->remember_token) ) {
            return 'ไม่พบรหัสความปลอดภัยนี้';
        }

        $user->remember_token = '';
        $user->status()->associate(UserStatus::whereName('normal')->first());

        if ( !$user->save() ) {
            return redirect()->back()->withErrors('ไม่สามารถบันทึกข้อมูลได้');
        }
        \SendMail::sendActivatedUser($user);
        return redirect()->action('UserController@getIndex', $id)->with('message', 'เปิดใช้งานชื่อผู้ใช้เรียบร้อยแล้ว');
    }

    public function getConfirmChangeEmail ($id, $token)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        if ( !Hash::check($token, $user->remember_token) ) {
            return 'ไม่พบรหัสความปลอดภัยนี้';
        }

        if ( $user->status->name == 'normal' ) {
            return 'คุณได้ทำการยืนยันชื่อผู้ใช้นี้แล้ว';
        }

        $user->remember_token = '';
        $user->status()->associate(UserStatus::whereName('normal')->first());

        if ( !$user->save() ) {
            return redirect()->action('UserController@getSecure', $id)->withErrors('ไม่สามารถบันทึกข้อมูลได้');
        }
        return redirect()->action('UserController@getSecure', $id)->with('message', 'การเปลี่ยนอีเมล์เสร็จเรียบร้อยแล้ว');
    }

    public function getProfile ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        return view('user.user-account', [
            'title' => 'ข้อมูลพื้นฐานและการติดต่อ',
            'user'  => $user ,
            'current_route' => 'profile',
        ]);

    }

    public function getAddress ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        return view('user.user-account-address', [
            'title' => 'ที่อยู่สำหรับจัดส่ง',
            'user'  => $user,
            'current_route' => 'profile',
        ]);
    }

    public function getContact ($id)
    {
        $user = User::get($id, true);
        if ( !$user ) {
            return 'Permission deny';
        }
        return view('user.user-account-contact', [
            'title' => 'ตั้งค่าบัญชีผู้ใช้ : การติดต่อ',
            'user'  => $user,
            'current_route' => 'contact',
        ]);

    }

    function is_alphanumeric ($str)
    {
        return preg_match('/^[A-Za-z0-9-_\s]+$/', $str);
    }

    public function postSaveData ()
    {

        $inputs = \Request::all();
        $user = \Auth::user()->user();
        $new_url = null;

        if ( !$user ) {
            return 'User Not Found';
        }

        foreach ( $inputs[ 'data' ] as $key => $value ) {

            if ( $value[ 'table' ] == 'user' ) {
                if ( $value[ 'type' ] === 'url' ) {
                    if ( !$this->is_alphanumeric($value[ 'data' ]) ) {
                        return response()->json([
                            'error' => true, 'message' => 'URL ต้องเป็นตัวอักษรภาษาอังกฤษและตัวเลขเท่านั้น'
                        ]);
                    }

                    $url = str_slug($value[ 'data' ], '-');

                    if ( !User::availableURL($url, [ $user->id ]) ) {
                        return response()->json([ 'error' => true, 'message' => 'URL นี้มีผู้ใช้เแล้ว' ]);
                    }

                    $user[ $value[ 'column' ] ] = $url;
                    $new_url = action('UserController@getIndex', $user->getID());
                } else {
                    $user[ $value[ 'column' ] ] = $value[ 'data' ];
                }
                if ( !$user->update() ) {
                    return response()->json([ 'error' => true, 'message' => 'เกิดข้อผิดพลาดกรุณาลองใหม่' ]);
                }
            } elseif ( $value[ 'table' ] === 'profile' ) {
                if ( $value[ 'type' ] === 'date' ) {
                    $date = explode('/', $value[ 'data' ]);
                    $value[ 'data' ] = $date[ 2 ] . '-' . $date[ 1 ] . '-' . $date[ 0 ];
                }
                $user->profile[ $value[ 'column' ] ] = $value[ 'data' ];

                if ( !$user->profile->update() ) {
                    return response()->json([ 'error' => true, 'message' => 'เกิดข้อผิดพลาดกรุณาลองใหม่' ]);
                }
            } elseif ( $value[ 'table' ] === 'option' ) {
                $user->option[ $value[ 'column' ] ] = $value[ 'data' ];

                if ( !$user->option->update() ) {
                    return response()->json([ 'error' => true, 'message' => 'เกิดข้อผิดพลาดกรุณาลองใหม่' ]);
                }
            }
        }


        return response()->json([
            'error'   => false,
            'message' => 'อัพเดทข้อมูลเรียบร้อย',
            'url'     => $new_url
        ]);
    }

    public function postUpdateContact ($user_id)
    {
        $user = User::get($user_id);

        if( !$user ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลผู้ใช้นี้' ]);
        }

        $inputs = \Request::except('_token');

        $user->update(array_only($inputs, [
            'full_name', 'username', 'email', 'sex'
        ]));

        $inputs['birthday'] = \Carbon::createFromFormat('d/m/Y', $inputs['birthday']);

        $user->profile->update(array_only($inputs, [
            'phone', 'birthday', 'address', 'building', 'district', 'province', 'zipcode'
        ]));

        if(!$user->save()) {
            return redirect()->back()->withErrors(['ไม่สามารถบันทึกข้อมูลได้']);
        }

        return redirect()->back()->with(['message' => 'บันทึกข้อมูลเรียบร้อย']);
    }
    public function getDeleteLineQR ($id)
    {
        $user = User::get($id);

        if ( !$user ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลผู้ใช้นี้' ]);
        }

        $profile = $user->profile;

        if ( !$profile ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลโปรไฟล์' ]);
        }

        $profile->line_qr = null;

        if ( $profile->save() ) {
            return redirect()->back()->with([ 'message' => 'ลบรูปภาพ Line QR code เรียบร้อยแล้ว' ]);
        }

        return redirect()->back()->withErrors([ 'การบันทึกข้อมูลผิดพลาด' ]);
    }

    public function getLineQR ($id)
    {
        $user = User::get($id);

        if ( !$user ) {
            return redirect()->back()->withErrors([ 'ไม่พบข้อมูลผู้ใช้นี้' ]);
        }

        return response()->download($user->profile->line_qr);
    }

    public function postUploadLineQR ($id)
    {
        $inputs = \Request::all();

        if ( !$inputs[ 'file' ]->isValid() ) {
            return response()->json([
                'error'   => true,
                'message' => 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์กรุณาลองใหม่'
            ]);
        }

        $user = User::get($id, true);

        if ( !$user ) {
            return response()->json([
                'error'   => true,
                'message' => 'ไม่พบผู้ใช้ที่ต้องการกรุณาลองใหม่'
            ]);
        }
        $ext = $inputs[ 'file' ]->getClientOriginalExtension();

        $path = 'storage/users/' . str_pad($user->id, 6, '0', STR_PAD_LEFT);

        $name = 'line-qr-' . uniqid() . '.' . $ext;
        $full_path = $path . '/' . $name;

        if ( $inputs[ 'file' ]->move(
            $path,
            $name
        )
        ) {
            $user->profile->line_qr = $full_path;
            $user->profile->update();
            return response()->json([
                'error'     => false,
                'file_path' => url('/') . '/' . $full_path
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์กรุณาลองใหม่'
        ]);
    }

    public function getFollower ($id)
    {
        $user = User::get($id);

        if ( !$user ) {
            return 'User Not found';
        }

        $followers = UserFollow::whereUserId($user->id)->paginate(20);

        return view('user.user-follow', [
            'title'     => 'ผู้ติดตาม',
            'user'      => $user,
            'followers' => $followers,
            'current_route' => 'followers',
        ]);


    }

    public function getFollowing ($id)
    {
        $user = User::get($id);

        if ( !$user ) {
            return 'User Not found';
        }
        
        $followers = $user->followings()->paginate(20);
        return view('user.user-following', [
            'title'     => 'กำลังติดตาม',
            'user'      => $user,
            'followers' => $followers,
            'current_route' => 'following',
        ]);

    }


    public function getFavorite ($id)
    {
        $user = User::get($id);

        if ( !$user ) {
            return 'User Not found';
        }
        $favorites = \App\CampaignFavorite::whereUserId($user->id)
            ->whereHas('campaign', function ($q) {
                $q->whereNotNull('id');
            })->paginate(12);
        return view('user.user-favorite', [
            'title'     => 'แคมเปญที่ชื่นชอบ',
            'user'      => $user,
            'favorites' => $favorites,
            'current_route' => 'favorite',
        ]);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRequest()
    {
        return $this->currentRequest;
    }
    public function getCurrentRoute()
    {
        return $this->currentRoute;
    }

    public function getOrderHistory ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $orders = Order::orderBy('updated_at', 'desc')->where('user_id', $user->id)
            ->with('items')->paginate(10);

        return view('user.user-order-history', [
            'title'  => 'ประวัติการสั่งซื้อ',
            'user'   => $user,
            'orders' => $orders,
            'current_route' => 'order-history',
        ]);
    }

    public function getShowOrder ($id, $order_id)
    {
        $user = User::get($id, true);
        if ( !$user ) {
            abort(404);
        }

        $order = Order::where('id', $order_id)->with('items')->first();

        if ( !$order ) {
            abort(404);
        }
        return view('user.view-user-order', [
            'title' => 'รายละเอียดการสั่งซื้อสินค้า เลขที่ ' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'order' => $order,
            'user'  => $user,
            'current_route' => 'order-history',
        ]);

    }

    public function getManagerLogin ()
    {
        return view('manager.login', [
            'title' => 'เข้าสู่ระบบ',
        ]);
    }

    public function getPaymentRequest ()
    {
        return view('manager.payment-request', [
            'title' => 'ยื่นคำขอโอนเงิน',
        ]);
    }

    public function getMessage ($user_id)
    {
        return view('manager.message', [
            'title' => 'ข้อความแจ้งเตือน',
            'current_route' => 'message',
        ]);
    }

    public function getNotify($user_id)
    {
        return view('user.user-notify', [
            'title' => 'ข้อความแจ้งเตือน',
            'current_route' => 'user-notify',
        ]);
    }

    public function getSellReport ()
    {
        return view('manager.sell-report', [
            'title' => 'รายงานยอดขาย',
        ]);
    }

    /*
    public function getCampaign($id, $status_name = '')
    {
        $total_profit = 0;
        $total_running_campaign = 0;
        $total_sell = 0;
        $user = User::get($id, true);

        if (!$user) {
            return 'Permission deny';
        }


        $now = \Carbon::now();
        $start_date = \Carbon::create($now->year, $now->month, 1, 0, 0, 0);
        $end_date = \Carbon::now();
        if (\Request::has('period')) {
            $period = \Request::get('period');

            if ($period == 'td') {
                $start_date = \Carbon::create($now->year, $now->month, $now->day, 0, 0, 0);
            } elseif ($period == 'lm') {
                $end_date = \Carbon::create($now->year, $now->month, 1, 0, 0, 0)->subDay();
                $start_date = $start_date->subMonth();
            } elseif ($period == 'l3m') {
                $start_date = \Carbon::create($now->year, $now->month, 1, 0, 0, 0)->subMonths(3);
                $end_date = \Carbon::create($now->year, $now->month, 1, 0, 0, 0)->subDay();
            } elseif ($period == 'all') {
                $start_date = $user->created_at;
            }
        }

        $camp = Campaign::where('user_id', $user->id)
            ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)
            ->whereBetween('start', [ $start_date, $end_date ])
            ->with('orders')->get();

        foreach ($camp as $key => $value) {
            $total_profit += $value->totalProfit();
            $total_sell += $value->totalOrder();

            if ($value->status->name == 'running') {
                $total_running_campaign += 1;
            }
        }


        if ($status_name == '') {
            $campaigns = Campaign::where('user_id', $user->id)
                ->with('produce_status', 'design')
                ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)
                ->where('campaign_status_id', '<>', \App\CampaignStatus::whereName('user_ban')->first()->id)
                ->orderBy('end', 'desc')->paginate(10);
        } else {
            $campaigns = Campaign::where('user_id', $user->id)
                ->with('produce_status', 'design')
                ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)
                ->where('campaign_status_id', \App\CampaignStatus::whereName($status_name)->first()->id)
                ->orderBy('end', 'desc')->paginate(10);
        }

        return view('user.user-campaign', [
            'title' => 'ประวัติการขาย',
            'campaigns' => $campaigns,
            'user' => $user,
            'status_name' => $status_name,
            'total_profit' => $total_profit,
            'total_running_campaign' => $total_running_campaign,
            'total_sell' => $total_sell
        ]);
    }
    */

    public function getFinancial ()
    {

        return view('user.financial', [
            'title' => 'ประวัติด้านการเงิน',
            'user'  => \Auth::user()->user(),
        ]);
    }

    public function getBankAccount ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $bank_account = $user->bank_account;

        return view('user.change-bank-account', [
            'title'        => 'บัญชีธนาคาร',
            'user'         => \Auth::user()->user(),
            'bank_account' => $bank_account
        ]);

    }

    public function postSaveBankAccount ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $inputs = \Request::all();

        if ( !Hash::check($inputs[ 'password' ], $user->password) ) {
            return redirect()->back()->withInput()->withErrors([ 'รหัสผ่านผิดกรุณาลองใหม่อีกครั้ง' ]);
        }

        $bank_account = $user->bank_account;

        if ( $bank_account ) {
            $old_bank_no = $bank_account->no;

            $bank_account->no = $inputs[ 'no' ];
            $bank_account->name = $inputs[ 'name' ];
            $bank_account->branch = $inputs[ 'branch' ];
            $bank_account->bank_name = $inputs[ 'bank_name' ];

            if ( $bank_account->save() ) {
                // TODO::Send email for updating bank account
                $this->sendEmailUpdateBankAccount($user->id, $old_bank_no);
            }
        } else {
            $bank_account = \App\UserBankAccount::create([
                'id'        => $user->id,
                'no'        => $inputs[ 'no' ],
                'name'      => $inputs[ 'name' ],
                'branch'    => $inputs[ 'branch' ],
                'bank_name' => $inputs[ 'bank_name' ],
            ]);

            // TODO::Send email for adding bank account
            $this->sendEmailAddBankAccount($user->id);
        }

        if ( $bank_account ) {
            return redirect()->back()->with('message', 'บันทึกบัญชีธนาคารเรียบร้อยแล้ว');
        }

        return redirect()->back()->withInput()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง' ]);
    }

    function sendEmailAddBankAccount ($user_id)
    {
        $user = User::find($user_id);
        if ( $user ) {
            \Mail::send('backend.mail.add-bookbank', [
                'id'           => $user->getID(),
                'user'         => $user,
                'bank_account' => $user->bank_account,
                'created_at'   => $user->bank_account->getCreatedDate()
            ], function ($m) use ($user) {
                $m->to($user->email, $user->full_name)->subject('คุณได้เพิ่มบัญชีธนารของคุณแล้ว');
            });
        }

        \Log::error('Cannot found user to send email for notified add bank account');
    }

    function sendEmailUpdateBankAccount ($user_id, $old_bank_no)
    {
        $user = User::find($user_id);
        if ( $user ) {
            \Mail::send('backend.mail.edit-bookbank', [
                'id'           => $user->getID(),
                'user'         => $user,
                'bank_account' => $user->bank_account,
                'old_bank_no'  => $old_bank_no,
                'created_at'   => $user->bank_account->getUpdatedDate()
            ], function ($m) use ($user) {
                $m->to($user->email, $user->full_name)->subject('คุณได้แก้ไขข้อมูลบัญชีธนาคารของคุณแล้ว');
            });
        }

        \Log::error('Cannot found user to send email for notified add bank account');
    }

    public function getShowCampaign ($id, $campaign_id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $campaign = Campaign::where('id', $campaign_id)->where('user_id', $user->id)->first();

        if ( $campaign ) {
            $orders = $this->orderedProductById($campaign->id);
            return view('user.user-campaign-view', [
                'title'    => 'รายละเอียดแคมเปญ',
                'campaign' => $campaign,
                'orders'   => $orders,
                'user'     => \Auth::user()->user()
            ]);

        }

        return view('errors.campaign-not-found', [ 'title' => 'Campaign Not Found' ]);

    }

    public function getListCampaign ($id)
    {
        $user = User::get($id);

        if ( !$user ) {
            return 'User Not Found';
        }
        $campaigns = Campaign::whereUserId($user->id)
            ->whereIn('campaign_status_id', [
                CampaignStatus::whereName('running')->first()->id,
                CampaignStatus::whereName('close')->first()->id
            ])
            ->where('campaign_type_id', \App\CampaignType::whereName('sell')->first()->id)
            ->paginate(12);
        return view('user.user-view', [
            'title'     => 'รายการแคมเปญ',
            'user'      => $user,
            'campaigns' => $campaigns
        ]);

    }

    function orderedProductById ($id)
    {
        $orders = \App\Order::where('campaign_id', $id)
            ->where('payment_status_id', \App\PaymentStatus::whereName('paid')->first()->id)
            ->with('allItems', 'allItems.item', 'allItems.item.product')->get();
        $items = [ ];
        foreach ( $orders as $index => $order ) {
            foreach ( $order->allItems as $key => $item ) {
                if ( isset($items[ $item->item->product_id ][ 'colors' ][ $item->item->product_image->color_name ][ 'sizes' ][ $item->size ]) ) {
                    $items[ $item->item->product_id ][ 'colors' ][ $item->item->product_image->color_name ][ 'sizes' ][ $item->size ] += $item->qty;
                    $items[ $item->item->product_id ][ 'total' ] += $item->qty;
                } else {
                    $items[ $item->item->product_id ][ 'name' ] = $item->item->product->name;
                    $items[ $item->item->product_id ][ 'available_size' ] = $item->item->product->available_size;
                    $items[ $item->item->product_id ][ 'sell_price' ] = $item->item->sell_price;
                    isset($items[ $item->item->product_id ][ 'total' ]) ? $items[ $item->item->product_id ][ 'total' ] += $item->qty : $items[ $item->item->product_id ][ 'total' ] = $item->qty;
                    $items[ $item->item->product_id ][ 'colors' ][ $item->item->product_image->color_name ][ 'sizes' ][ $item->size ] = $item->qty;
                }
            }
        }

        return $items;
    }

    public function getSetUserSubscribe ($follower_id, $user_id)
    {
        $user_follow = UserFollow::where('follower_id', $follower_id)
            ->where('user_id', $user_id)->first();

        if ( $user_follow ) {
            $user_follow->delete();
            return response()->json([ 'error' => false, 'message' => 'removed' ]);
        } else {
            UserFollow::create([
                'follower_id' => $follower_id,
                'user_id'     => $user_id
            ]);
        }
        return response()->json([ 'error' => false, 'message' => 'added' ]);
    }

    public function postUploadAvatar ($user_id)
    {
        $inputs = \Request::all();
        if ( $inputs[ 'avatar_file' ]->isValid() ) {
            $ext = $inputs[ 'avatar_file' ]->getClientOriginalExtension();
            $mime = $inputs[ 'avatar_file' ]->getMimeType();
            $mime_type = config('constant.allow_mime_type');

            if ( !in_array($mime, $mime_type) ) {
                return redirect()->back()->withErrors([ 'ภาพโปรไฟล์ของคุณต้องเป็นประเภท JPG หรือ PNG เท่านั้น' ]);
            }

            if ( $inputs[ 'avatar_file' ]->getSize() > 2097152 ) {
                return redirect()->back()->withErrors([ 'message' => 'ขนาดไฟลต้องมีขนาดไม่เกิน 2 Mb' ]);
            }

            $path = 'images/users/' . str_pad($user_id, 6, '0', STR_PAD_LEFT);

            $original_name = 'profile-' . uniqid() . '-original.' . $ext;
            $name = 'profile-' . uniqid() . '.' . $ext;
            $original_full_path = $path . '/' . $original_name;
            $full_path = $path . '/' . $name;
            \Storage::makeDirectory($path);

            if ( !\Storage::disk('local')->put($original_full_path, \File::get($inputs[ 'avatar_file' ])) ) {
                return redirect()->back()->withErrors([ 'ไม่สามารถบันทึกรูปภาพได้กรุณาลองใหม่' ]);
            }

            $image = \Image::make('../storage/app/' . $original_full_path);


            $width = $image->getWidth();
            $height = $image->getHeight();

            if ( $height > $width && $width > config('constant.profile_width') ) {
                $image->resize(config('constant.profile_width'), null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $height = $image->getHeight();

                if ( $height > config('constant.profile_height') ) {
                    $x = round(($height - config('constant.profile_height')) / 2);
                    $image->crop(500, 500, null, $x);
                }
            } elseif ( $width > $height && $height > config('constant.profile_height') ) {
                $image->resize(null, config('constant.profile_height'), function ($constraint) {
                    $constraint->aspectRatio();
                });

                $width = $image->getWidth();

                if ( $width > config('constant.profile_width') ) {
                    $x = round(($width - config('constant.profile_width')) / 2);
                    $image->crop(500, 500, $x, 0);
                }
            }

            $image->save();

            $image->resize(64, 64);
            $image->save('../storage/app/' . $full_path);

            $user = User::find($user_id);
            $user->avatar = $name;
            $user->avatar_original = $original_name;

            if ( $user->update() ) {
                return redirect()->back()->with([ 'message' => 'บันทึกรูปภาพโปรไฟล์เรียบร้อย' ]);
            }

            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพกรุณาลองใหม่' ]);

        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพกรุณาลองใหม่' ]);
    }

    public function postUploadCover ($user_id)
    {
        $inputs = \Request::all();
        if ( $inputs[ 'cover_file' ]->isValid() ) {
            $ext = $inputs[ 'cover_file' ]->getClientOriginalExtension();
            $mime = $inputs[ 'cover_file' ]->getMimeType();
            $mime_type = config('constant.allow_mime_type');

            if ( !in_array($mime, $mime_type) ) {
                return redirect()->back()->withErrors([ 'ภาพโปรไฟล์ของคุณต้องเป็นประเภท JPG หรือ PNG เท่านั้น' ]);
            }

            if ( $inputs[ 'cover_file' ]->getSize() > 3145728 ) {
                return redirect()->back()->withErrors([ 'message' => 'ขนาดไฟลต้องมีขนาดไม่เกิน 3 Mb' ]);
            }

            $path = 'storage/users/' . str_pad($user_id, 6, '0', STR_PAD_LEFT);

            $name = 'profile-' . uniqid() . '.' . $ext;
            $full_path = $path . '/' . $name;
            if ( $inputs[ 'cover_file' ]->move(
                $path,
                $name
            )
            ) {

                $user = User::find($user_id);
                $user->cover = $full_path;
                if ( $user->update() ) {
                    return redirect()->back()->with([ 'message' => 'บันทึกรูปภาพหน้าปกเรียบร้อย' ]);
                }

                return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพกรุณาลองใหม่' ]);
            }

        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพกรุณาลองใหม่' ]);
    }

    public function getFinance ()
    {
        if ( \Auth::user()->check() ) {
            $payouts = \App\Payout::where('user_id', \Auth::user()->user()->id)->orderBy('updated_at', 'dsc')->paginate(20);
            return view('user.financial', [
                'title'   => 'ประวัติด้านการเงิน',
                'payouts' => $payouts,
                'user'    => \Auth::user()->user()
            ]);
        }

        return 'Permission deny';
    }

    public function getMobileUserMenu ()
    {
        return view('user.mobile-user-menu', [
            'title' => 'เมนูผู้ใช้',
            'user'  => \Auth::user()->user()
        ]);
    }


    public function getDeleteCampaign ($id, $campaign_id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        if ( $campaign->end > \Carbon::now() ) {
            return redirect()->back()->withErrors([ 'คุณไม่สามารถลบแคมเปญที่กำลังทำงานอยู่ได้' ]);
        }
        $campaign->deleteOrder();
        if ( $campaign->delete() ) {
            return redirect()->action('UserController@getCampaign', $user->getID())->with([ 'messages' => 'ระงับแคมเปญเสร็จเรียบร้อย' ]);
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการลบข้อมูล' ]);
    }

    function getBanCampaign ($id, $campaign_id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        if ( $campaign->status->name == 'user_ban' ) {
            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);
        }

        $campaign->status()->associate(CampaignStatus::whereName('user_ban')->first());

        if ( $campaign->save() ) {
            return redirect()->back()->with([ 'messages' => 'ระงับแคมเปญเสร็จเรียบร้อย' ]);
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);
    }

    function getActiveCampaign ($id, $campaign_id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        if ( $campaign->status->name != 'user_ban' ) {
            return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);
        }

        if ( $campaign->end < \Carbon::now() ) {
            $campaign->status()->associate(CampaignStatus::whereName('close')->first());
        } else {
            $campaign->status()->associate(CampaignStatus::whereName('running')->first());
        }

        if ( $campaign->save() ) {
            return redirect()->back()->with([ 'message' => 'เปิดแคมเปญเสร็จเรียบร้อย' ]);
        }

        return redirect()->back()->withErrors([ 'เกิดข้อผิดพลาดในการบันทึกข้อมูล' ]);
    }


    /*
     * New system function
     */

    public function getEditCampaign ($user_id, $campaign_id)
    {
        $campaign = Campaign::with([
            'products' => function ($q) {
                $q->where('is_active', 1);
                $q->orderBy('product_id');
            }
        ])->where('id', $campaign_id)
            ->first();

        $user = User::get($user_id, true);

        if ( !$user ) {
            return 'User not found';
        }

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        return view('user.edit-campaign', [
            'title'    => 'แก้ไขแคมเปญ ' . $campaign->title,
            'user'     => $user,
            'campaign' => $campaign
        ]);
    }

    public function getRemoveProduct ($user_id, $campaign_product_id)
    {
        $user = User::get($user_id, true);

        if ( !$user ) {
            return 'Permission deny';
        }

        $campaign_product = CampaignProduct::find($campaign_product_id);
        if ( !$campaign_product ) {
            return redirect()->back()->withErrors([ 'ไม่พบสินค้าที่ต้องการ' ]);
        }

        $campaign_product->is_active = false;

        if ( $campaign_product->update() ) {
            return redirect()->back()->with([ 'message' => 'ลบสินค้าเรียบร้อย' ]);
        }

        return redirect()->back()->withErrors([ 'ไม่สามารถลบสินค้าได้' ]);
    }

    public function postUpdateCampaign ($user_id, $campaign_id)
    {
        $user = User::get($user_id, true);

        if ( !$user ) {
            return 'Permission deny';
        }
        $campaign = Campaign::find($campaign_id);

        if ( !$campaign ) {
            return 'Campaign not found';
        }

        $inputs = \Request::all();
        $end = \Carbon::now()->addDays(intVal($inputs[ 'end_amount' ]));
        $campaign->title = $inputs[ 'title' ];
        $campaign->description = $inputs[ 'description' ];
        $campaign->back_cover = $inputs[ 'back_cover' ];
        $campaign->goal = $inputs[ 'goal' ];
        $campaign->limit = $inputs[ 'limit' ];
        $campaign->end_amount = $inputs[ 'end_amount' ];
        $campaign->end = $end;
        if ( isset($inputs[ 'tags' ]) ) {
            CampaignTag::where('campaign_id', $campaign_id)->delete();
            foreach ( $inputs[ 'tags' ] as $tag ) {
                $tag_data = Tag::firstOrCreate([ 'name' => $tag ]);
                $campaign->tags()->attach($tag_data->id);
            }
        }

        if ( $campaign->update() ) {
            foreach ( $inputs[ 'products' ] as $key => $product ) {
                if ( $product[ 'id' ] == '' ) {
                    CampaignProduct::create($product);
                } else {
                    $pro = CampaignProduct::find($product[ 'id' ]);

                    $pro->product_id = $product[ 'product_id' ];
                    $pro->product_image_id = $product[ 'product_image_id' ];
                    $pro->sell_price = $product[ 'sell_price' ];
                    $pro->update();
                }
            }

            return response()->json([ 'error' => false, 'message' => 'บันทึกข้อมูลเรียบร้อย' ]);

        }

        return response()->json([ 'error' => true, 'message' => 'เกิดข้อผิดพลาดในการบันทึก' ]);
    }

    public function getCampaign ($id, $status_name = '')
    {
        $user = User::get($id);
        $campaigns = Campaign::where('user_id', $user->id)->paginate(20);
        return view('user.user-campaign', [
            'title'     => 'ประวัติการขาย',
            'user'      => $user,
            'campaigns' => $campaigns
        ]);

    }

    public function getWishlist ($id)
    {
        $user = User::get($id, true);

        if ( !$user ) {
            return 'User Not found';
        }

//        $campaign_wish_lists = CampaignWishList::whereUserId($user->id)
//            ->whereHas('campaign', function ($q) {
//                $q->whereNotNull('id');
//            })->paginate(20);
        $campaigns = $user->favorites()->canShowPublic()->get();
        return view('user.user-wishlist', [
            'title'               => 'รายการที่ชื่นชอบ',
            'user'                => $user,
//            'campaign_wish_lists' => $campaign_wish_lists,
            'campaigns' => $campaigns,
            'current_route' => 'wishlist',
        ]);
    }

    public function getAbout ($id)
    {
        $user = User::get($id);

        return view('user.user-about', [
            'title' => 'ข้อมูลการติดต่อ',
            'user'  => $user,
            'current_route' => 'about',
        ]);
    }


    public function getFile ($id, $file_name)
    {
        $user = User::find($id);

        if ( !$user ) {
            return '';
        }

        $file_name_array = explode('.', $file_name);
        $ext = last($file_name_array);

        $file = User::file($user->id, $file_name);

        $mime_type = '';

        if($ext == 'png') {
            $mime_type = 'image/png';
        } elseif($ext == 'jpg') {
            $mime_type = 'image/jpeg';
        }

        return response()->make($file, 200, ['content-type' => $mime_type]);
    }
    /*
     * End new system function
     */

    public function getCreatorShow($user_id)
    {
        $creator = User::get($user_id);
        $campaigns = $creator->campaigns()->active()->get();
        return view('user.creator-show', [
            'title'     => 'ประวัติการขาย',
            'creator'   => $creator,
            'campaigns' => $campaigns
        ]);
    }

    public function setReadNotification ()
    {
        if(! \NotificationService::setRead(\Auth::user()->user()->id)) {
            return response()->json(['success' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }

        return response()->json(['success' => true]);
    }
}