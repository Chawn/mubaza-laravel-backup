<?php namespace App;

use App\Campaign;
use App\CampaignFavorite;
use App\CampaignLike;
use App\CampaignReserve;
use App\CommentLike;
use App\UserFollow;
use App\UserStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword;
    use SoftDeletes;

    public $dates = [ 'deleted_at' ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email',
        'password', 'username',
        'sex', 'avatar', 'provider',
        'provider_id', 'is_social',
        'user_status_id', 'user_role_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token' ];

    public static function GetAll ($keyword = '')
    {
        $users = User::where('full_name', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->orWhere('username', 'like', '%' . $keyword . '%');

        return $users;
    }

    public function inActive ()
    {
        return ($this->status->id == UserStatus::inActive()->first()->id);
    }

    public function isActive ()
    {
        return ($this->user_status_id != UserStatus::whereName('banned')->first()->id);
    }

    public function isLiked ($campaign_id)
    {
        $campaign_like = CampaignLike::where('campaign_id', $campaign_id)
            ->where('user_id', $this->id)->count();
        if ( $campaign_like > 0 ) {
            return true;
        }

        return false;
    }

    public function isCommentLiked ($comment_id)
    {
        $campaign_like = CommentLike::where('comment_id', $comment_id)
            ->where('user_id', $this->id)->count();
        if ( $campaign_like > 0 ) {
            return true;
        }

        return false;
    }

//    public function isFavorited($campaign_id)
//    {
//        $campaign_favorite = CampaignFavorite::where('campaign_id', $campaign_id)
//            ->where('user_id', $this->id)->count();
//        if ($campaign_favorite > 0) {
//            return true;
//        }
//
//        return false;
//    }

    public function isSubscribed ($user_id)
    {
        $user_follow = UserFollow::where('user_id', $user_id)
            ->where('follower_id', $this->id)->count();
        if ( $user_follow > 0 ) {
            return true;
        }

        return false;
    }

    /**
     * Check duplicate email in db
     *
     * @param $email
     * @return bool
     */
    public static function emailCheck ($email)
    {
        $user = \App\User::whereEmail($email)->first();

        if ( $user ) {
            return true;
        }

        return false;
    }

    /**
     * Get user data by id or username and
     *
     * @param      $id
     * @param bool $is_secure
     * @return \Illuminate\Support\Collection|null|static
     * @internal param bool|false $private
     */
    public static function get ($id, $is_secure = false)
    {
        $user = null;
        if ( is_numeric($id) ) {
            if ( \Auth::user()->check() && \Auth::user()->user()->isOwner($id) ) {
                $user = \Auth::user()->user();
            } elseif ( !$is_secure || \Auth::user()->user()->role->name == config('constant.admin_role') ) {
                $user = User::find($id);
            }
        } else {
            $url = e($id);
            if ( \Auth::user()->check() && \Auth::user()->user()->isOwnerByUrl($url) ) {
                $user = \Auth::user()->user();
            } elseif ( !$is_secure || \Auth::user()->user()->role->name == config('constant.admin_role') ) {
                $user = User::whereUrl($url)->first();
            }
        }

        return $user;
    }

    /**
     * Get ID or username if username is null return id of user
     *
     * @return mixed
     */
    public function getID ()
    {
        return (is_null($this->url) ? $this->id : $this->url);
    }

    public function isOwner ($user_id)
    {
        return ($this->id == $user_id);
    }

    public function isOwnerByUrl ($url)
    {
        return ($this->url == $url);
    }

    public function getSell ()
    {
        $campaigns = Campaign::where('user_id', $this->id)
            ->where('campaign_type_id', CampaignType::whereName('sell')->first()->id)
            ->get();
        return $campaigns;
    }

    public static function countAll ($from = null, $to = null)
    {
        if ( $from != null && $to != null ) {
            return \DB::table('users')->whereBetween('created_at', [ $from, $to ])
                ->select(\DB::raw('count(*) as user_count'))->first();
        }
        return \DB::table('users')->select(\DB::raw('count(*) as user_count'))->first();

    }

    public static function availableURL ($url, $except = null)
    {
        $user = null;

        if ( $except ) {
            $user = \App\User::whereUrl($url)->whereNotIn('id', $except)->first();
        } else {
            $user = \App\User::whereUrl($url)->first();
        }
        if ( !$user ) {
            return true;
        }

        return false;
    }

    /**
     * Check user is reserved campaign
     *
     * @param $campaign_id
     * @return bool
     * @internal param $campign_id
     */
    public function isReserved ($campaign_id)
    {
        $reserved = CampaignReserve::where('campaign_id', $campaign_id)->where('email', $this->email)->first();

        if ( $reserved ) {
            return true;
        }

        return false;
    }

    /*====================
     * New Function System
     *====================*/
    public function getName ()
    {
        if ( !$this->option ) {
            return '';
        }

        return $this->option->show_full_name ? $this->full_name : $this->username;
    }

    public static function getFullName ($user_id)
    {
        $user = self::find($user_id);

        if ( !$user ) {
            return '';
        }

        return $user->option->show_full_name ? $user->full_name : $user->username;
    }

    public function isAddedToWishList ($campaign_id)
    {
        $campaign_wish_list = CampaignWishList::where('campaign_id', $campaign_id)
            ->where('user_id', $this->id)->count();
        if ( $campaign_wish_list > 0 ) {
            return true;
        }

        return false;
    }

    public function createAssociate ()
    {
        if ( $this->affiliate != null ) {
            return true;
        }
        $this->is_designer = true;
        $this->is_affiliate = true;

        $affiliate = new Affiliate();

        $affiliate->status()->associate(AssociateStatus::active()->first());
        return $this->affiliate()->save($affiliate);
    }

    public function clearOtp ()
    {
        $this->user_activates()->delete();
    }

    public static function file ($id, $file_name)
    {
        return \Storage::get('images/users/' . str_pad($id, 6, 0, STR_PAD_LEFT) . '/' . $file_name);
    }

    public function isAssociate ()
    {
        return $this->associate ? true : false;
    }
    /*
     * End New Function system
     */

    public function affiliate ()
    {
        return $this->hasOne('App\Affiliate');
    }

    public function associate ()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function followings ()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'user_id');
    }

    public function monthly_commissions ()
    {
        return $this->hasMany(MonthlyCommission::class);
    }

    public function user_activates ()
    {
        return $this->hasMany('App\UserActivate');
    }

    public function status ()
    {
        return $this->belongsTo('App\UserStatus', 'user_status_id');
    }

    public function role ()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id');
    }

    public function profile ()
    {
        return $this->hasOne('App\UserProfile', 'id');
    }

    public function option ()
    {
        return $this->hasOne('App\UserOption', 'id');
    }

    public function bank_account ()
    {
        return $this->hasOne('App\UserBankAccount', 'id');
    }

    public function orders ()
    {
        return $this->hasMany('App\Order');
    }

    public function collections ()
    {
        return $this->hasMany('App\Collection');
    }

    public function campaigns ()
    {
        return $this->hasMany('App\Campaign');
    }

    public function campaignLikes ()
    {
        return $this->hasMany('App\CampaignLike');
    }

    public function followers ()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'user_id', 'follower_id');
    }

    public function favorites ()
    {
        return $this->belongsToMany('App\Campaign', 'campaign_wish_lists', 'user_id', 'campaign_id');
    }

    public function payouts ()
    {
        return $this->hasMany(Payout::class);
    }

    public function notification ()
    {
        return $this->hasMany(Notification::class);
    }

    public function getAvatarAttribute ($value)
    {
        if ( $value === null || $value == '' ) {
            return asset('images/default/default-user.png');
        }

        if ( str_is('http*', $value) ) {
            return $value;
        }

        return action('UserController@getFile', [ $this->id, $value ]);

    }

    public function getAvatarOriginalAttribute ($value)
    {
        if ( $value === null || $value == '' ) {
            return asset('images/default/default-user.png');
        }

        if ( str_is('http*', $value) ) {
            return $value;
        }

        return action('UserController@getFile', [ $this->id, $value ]);

    }
}
