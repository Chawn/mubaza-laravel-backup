<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\OrderItem;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Get user data by id
     *
     * @param        $id
     * @param string $secret_key
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function getUser ($id, $secret_key = '')
    {
        if ( $secret_key == '' ) {
            return response()->json([
                'version'  => 0.1,
                'response' => User::where('id', $id)->select([ 'id', 'username', 'avatar', 'cover' ])->first()
            ]);
        }

        return null;
    }

    /**
     * Get Campaign data by id
     *
     * @param $id
     * @return mixed
     */
    public function getCampaign ($id)
    {
        return Campaign::find($id);
    }

    public function getProduct ($id = 0)
    {
        $data = Product::with([
            'colors' => function ($q) {
                $q->orderBy('primary', 'dsc');
            },
            'outline'
        ]);
        if ( $id == 0 ) {
            $data = $data->get();
        } else {
            $data = $data->whereId($id)->first();
        }

        return $data;
    }

    public function postAffiliateProfitByDate ()
    {
        $start = null;
        $end = null;

        if(\Request::has('start') && \Request::has('end')) {
            $start = \Carbon::createFromFormat('d/m/Y', \Request::get('start'));
            $end = \Carbon::createFromFormat('d/m/Y', \Request::get('end'));
        }

        $data = \CommissionService::affiliateProfitByDate(\Auth::user()->user()->affiliate->id, $start, $end);
//        dd($data);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function postCampaignProfitById ()
    {
        if ( !\Request::has('id') ) {
            return response()->json([ 'please provide campaign id' ]);
        }
        if ( !\Auth::user()->check() ) {
            return response()->json([ 'unauthorized access' ]);
        }
        $current_user = \Auth::user()->user();

        $campaign_ids = \Request::get('id');
        $start = \Carbon::now()->firstOfMonth();
        $end = \Carbon::now()->lastOfMonth()->hour(23)->minute(59)->minute(59);

        if ( \Request::has('start') && \Request::has('end') ) {
            if ( \Request::get('start') == \Request::get('end') ) {
                $start = \Carbon::createFromFormat('Y/m/d', \Request::get('start'))->startOfDay();
                $end = \Carbon::createFromFormat('Y/m/d', \Request::get('end'))->endOfDay();
            } else {
                $start = \Carbon::createFromFormat('Y/m/d', \Request::get('start'))->startOfDay();
                $end = \Carbon::createFromFormat('Y/m/d', \Request::get('end'))->endOfDay();
            }
        }

        $campaigns = Campaign::whereIn('id', $campaign_ids)->where('user_id', $current_user->id)->active();

        if ( !$campaigns ) {
            return response()->json([ null ]);
        }

        $items = [ ];
        $blank_item = [ ];

        $campaign_names = $campaigns->get(['id', 'title'])->toArray();

        $campaigns = $campaigns->get();

        foreach ( $campaign_ids as $campaign_id ) {
            $blank_item[ $campaign_id ] = 0;
        }

        $diff_days = $start->diffInDays($end);
        $date = \Carbon::createFromTimestamp($start->startOfDay()->timestamp);
        for($i = 1; $i <= $diff_days; $i++) {
            $date_start = \Carbon::createFromTimestamp($date->startOfDay()->timestamp);
            $date_end = \Carbon::createFromTimestamp($date->endOfDay()->timestamp);

            foreach ( $campaigns as $campaign ) {
                $order_items = $campaign->order_items()
                    ->approvedRange($date_start, $date_end)->get();

                if(!isset($items[ $date_start->timestamp ])) {
                    $items[ $date_start->timestamp] = $blank_item;
                }

                foreach ( $order_items as $order_item ) {
                    if ( isset($items[ $date_start->timestamp ][ $campaign->id ]) ) {
                        $items[ $date_start->timestamp ][ $campaign->id ] += $order_item->creator_commission;
                    } else {
                        $items[ $date_start->timestamp ][ $campaign->id ] = $order_item->creator_commission;
                    }
                }
            }
            $date->addDay();
        }
        $ordered_array = [ ];
        foreach ( $items as $key => $item ) {
            $ordered_array[ \Carbon::createFromTimeStamp($key)->format('d/m/Y') ] = array_flatten($item);
        }
        return response()->json([
            'success' => true,
            'columns' => $campaign_names,
            'rows'    => $ordered_array,
            'start'   => $start->format('d/m/Y'),
            'end'     => $end->format('d/m/Y')
        ]);
    }

    public function postSearch ()
    {
        if(!\Request::has('search_criteria')) {
            return response()->json(['success' => false, 'message' => 'ข้อมูลการค้นหาไม่เพียงพอ']);
        }
        $result = \CampaignService::search(\Request::get('search_criteria'));

        $items = [ ];
        $campaigns = $result->paginate(12);
        foreach ( $campaigns as $campaign ) {
            array_push($items, view('layouts.include.product-box-search', [ 'campaign' => $campaign ])->render());
        }
        return response()->json([
            'success'      => true,
            'current_page' => $campaigns->currentPage(),
            'last_page'    => $campaigns->lastPage(),
            'total'        => $campaigns->total(),
            'items'        => $items
        ]);
    }
}