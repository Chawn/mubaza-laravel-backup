<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class UserBankAccount extends Model {

	public $fillable = [
        'id','no','name','branch','bank_name'
    ];

    public function getBankNo()
    {
        if(strlen($this->no) < 10)
        {
            return $this->no;
        }
        $no = str_replace('-', '', $this->no);
        return substr($no, 0, 3) . '-' . substr($no, 3, 1) . '-' . substr($no, 4, 5) . '-' . substr($no, 9, 1);
    }
    public function getCreatedDate($locale = 'th')
    {
        Date::setLocale($locale);
        return Date::parse($this->created_at)->format('d F Y H:i');
    }
    public function getUpdatedDate($locale = 'th')
    {
        Date::setLocale($locale);
        return Date::parse($this->created_at)->format('d F Y H:i');
    }

}
