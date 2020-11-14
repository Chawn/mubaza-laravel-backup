<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/9/2015 AD
 * Time: 09:24
 */

namespace App\Lib\Ggseven;

use App\Campaign;
use App\CampaignCategory;
use App\CampaignStatus;
use App\Tag;
use App\UserStatus;

class CampaignService
{
    private $campaign_model;

    public function __construct (Campaign $campaign_model)
    {
        $this->campaign_model = $campaign_model;
    }

    public function checking ()
    {
        return $this->campaign_model->check()->orderBy('created_at', 'desc');
    }
    public function getNewCampaign($limit)
    {
    	$campaigns = $this->campaign_model->orderBy('created_at','desc')->active()->take(3)->get();
        return $campaigns;
    }

    public function search ($data)
    {
        $result = \DB::table('campaigns')
            ->rightJoin('campaign_products', 'campaign_products.campaign_id', '=', 'campaigns.id')
            ->rightJoin('users', 'users.id', '=', 'campaigns.user_id')
            ->rightJoin('campaign_tag', 'campaign_tag.campaign_id', '=', 'campaigns.id')
            ->where('campaign_status_id', CampaignStatus::active()->first()->id)
            ->where(function ($query) {
                $query->where('campaign_products.is_primary', true);
                $query->where('campaign_products.is_deleted', false);
            })
            ->where('users.user_status_id', '<>', UserStatus::banned()->first()->id)
            ->groupBy('campaigns.id')
            ->orderBy('id', 'dsc');
        if ( array_has($data, 'keyword') ) {
            $result = $result->where('campaigns.title', 'LIKE', '%' . $data[ 'keyword' ] . '%');

            $category = CampaignCategory::whereName($data[ 'keyword' ])->first();

            if ( $category ) {
                $result = $result->where('campaign_category_id', $category->id);
            }

            $tag = Tag::whereName($data['keyword'])->first();

            if($tag) {
                $result = $result->orWhere('campaign_tag.tag_id', $tag->id);
            }
        }

        if ( array_has($data, 'category_id') && $data[ 'category_id' ] != '' ) {
            $result = $result->where('campaigns.campaign_category_id', $data[ 'category_id' ]);
        }

        if ( array_has($data, 'price_start') && $data[ 'price_start' ] != '' ) {
            $result = $result->where('campaign_products.sell_price', '>=', $data[ 'price_start' ]);
        }

        if ( array_has($data, 'price_end') && $data[ 'price_end' ] != '' ) {
            $result = $result->where('campaign_products.sell_price', '<=', $data[ 'price_end' ]);
        }

        if ( array_has($data, 'color_id') && $data['color_id']) {
            $ids = [];

            foreach($data['color_id'] as $id) {
                array_push($ids, intval($id));
            }
            $result = $result->whereIn('campaign_products.product_color_id', $ids);
        }

        if ( array_has($data, 'order_by') && $data[ 'order_by' ] != '' ) {
            if ( $data[ 'order_by' ] == 'hot' ) {
                $result = $result->join('order_items', 'order_items.campaign_product_id', '=', 'campaign_products.id');
            } elseif ( array_has($data, 'sort_by') ) {
                $result = $result->orderBy($data[ 'order_by' ], $data[ 'sort_by' ]);
            } else {
                $result = $result->orderBy($data[ 'order_by' ]);
            }
        }

        if ( array_has($data, 'order_by') && $data[ 'order_by' ] == 'hot' ) {
            $result = $result->whereBetween('order_items.approved_at', [
                \Carbon::now()->subMonth()->startOfMonth()->startOfDay(),
                \Carbon::now()->endOfDay()
            ]);
            return $result->select([
                'campaigns.id',
                'title',
                'campaigns.url',
                'campaign_products.image_front_small',
                'campaign_products.image_front_medium',
                'campaign_products.image_front_large',
                'sell_price',
                \DB::raw('SUM(order_items.qty) as total_sell')
            ])->orderBy('total_sell', 'dsc');
        }

        return $result->select([
            'campaigns.id',
            'title',
            'campaigns.url',
            'campaign_products.image_front_small',
            'campaign_products.image_front_medium',
            'campaign_products.image_front_large',
            'sell_price'
        ]);
    }

    public function recommended ($limit = 12)
    {
        return $this->campaign_model
            ->canShow()
            ->whereHas('products', function($query) {
                $query->whereNotNull('id');
            })
            ->where('is_recommended', true)
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
    }

    public function hot ($limit = 12)
    {
        return $this->campaign_model->canShow()
            ->whereHas('products', function($query) {
                $query->whereNotNull('id');
            })
            ->where('is_hot', true)
            ->orderBy('created_at','desc')
            ->take($limit)
            ->get();
    }

    public function open ($campaign_id)
    {
        $campaign = $this->campaign_model->where('id', $campaign_id)->first();

        if( !$campaign ) {
            return false;
        }

        $campaign->status()->associate(CampaignStatus::active()->first());

        if ( !$campaign->save() ) {
            return false;
        }

        return true;
    }

    /**
     * Close campaign cannot show in public
     * @param $campaign_id
     * @return bool
     */
    public function close ($campaign_id)
    {
        $campaign = $this->campaign_model->where('id', $campaign_id)->first();

        if( !$campaign ) {
            return false;
        }

        $campaign->status()->associate(CampaignStatus::close()->first());

        if ( !$campaign->save() ) {
            return false;
        }

        return true;
    }

    public function comments ($campaign_id, $order = 'like')
    {
        $campaign = $this->campaign_model->where('id', $campaign_id)->first();
//        $comments = $campaign->comments()->get();
        $comments = \DB::table('comments')
//            ->leftJoin('comments', 'campaigns.id', '=', 'comments.campaign_id')
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->leftJoin('comment_likes', 'comment_likes.comment_id', '=', 'comments.id')
            ->where('comments.campaign_id', $campaign_id)
            ->select(\DB::raw('count(comment_likes.id) as like_count, comments.id,
                comments.message,
                comments.campaign_id,
                comments.updated_at,
                comments.user_id,
                users.avatar,
                users.full_name,
                users.username'))
            ->groupBy('comments.id');

        if($order == 'likes') {
            $comments = $comments->orderBy(\DB::raw('count(comment_likes.id)'), 'desc');
        } else if($order == 'newer') {
            $comments = $comments->orderBy('comments.updated_at', 'desc');
        }

        return $comments;
    }

    public function topTag ($limit = 4)
    {
        $tags = \DB::table('tags')->rightJoin('campaign_tag', 'campaign_tag.tag_id', '=', 'tags.id');
        $tags = $tags->groupBy('tags.id')->select([
            'tags.id',
            'tags.name',
            \DB::raw('COUNT(campaign_tag.campaign_id) as campaign_count')
            ])->orderByRaw('campaign_count DESC')->take($limit);
        return $tags->get();
    }
}