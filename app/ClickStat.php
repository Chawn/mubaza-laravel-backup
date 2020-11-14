<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClickStat extends Model
{
    public $dates = ['request_time'];
    public $fillable = [
        'method',
        'source',
        'client_ip',
        'agent',
        'landing_page',
        'query_string',
        'affiliate_id',
        'request_time'
    ];
}
