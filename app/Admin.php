<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email',
        'password', 'username',
        'sex', 'avatar', 'admin_status_id', 'admin_role_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function setPasswordAttribute ($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function scopeActive ($query)
    {
        return $query->where('admin_status_id', AdminStatus::active()->first()->id);
    }

    public function scopeInActive ($query)
    {
        return $query->where('admin_status_id', AdminStatus::inActive()->first()->id);
    }

    public function scopeBanned ($query)
    {
        return $query->where('admin_status_id', AdminStatus::banned()->first()->id);
    }

    public function setStatus ($status_name)
    {
        $this->status()->associate(AdminStatus::whereName($status_name)->first()->id);

        return $this->save();
    }
    public function status ()
    {
        return $this->belongsTo(AdminStatus::class, 'admin_status_id');
    }

    public function role ()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }
}
