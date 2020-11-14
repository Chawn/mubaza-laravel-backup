<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class   Report extends Model {

    public $fillable = [
      'report_type_id', 'detail', 'reporter_id', 'user_id', 'campaign_id'
    ];

    public static function GetAll($opened = false)
    {
        return Report::where('is_opened', $opened)->orderBy('created_at', 'desc');
    }

    public function reporter()
    {
        return $this->belongsTo('App\User', 'reporter_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id');
    }
    public function type() {
        return $this->belongsTo('App\ReportType', 'report_type_id');
    }
}
