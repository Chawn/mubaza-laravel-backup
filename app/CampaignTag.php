<?php namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class CampaignTag extends Model {

	public $timestamps = false;
    public $table = 'campaign_tag';
    public $fillable = [
        'campaign_id', 'tag_id'
    ];

    /**
     * Get hit tag for most used tag in campaign
     * @param int $amount
     * @return mixed
     */
    public static function HitTag($amount = 10)
    {
        return DB::table('campaign_tag')
            ->join('campaigns', 'campaigns.id', '=', 'campaign_tag.campaign_id')
            ->join('tags', 'tags.id', '=', 'campaign_tag.tag_id')
            ->select(DB::raw('tags.name, count("campaigns.id") as count_tag'))
            ->orderBy('count_tag', 'desc')
            ->groupBy('campaign_tag.tag_id')->take($amount)->get();
    }
    public function tag() {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
    public function campaigns() {
        return $this->belongsTo('App\Campaign', 'campaign_id');
    }

}
