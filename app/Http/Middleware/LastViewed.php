<?php

namespace App\Http\Middleware;

use App\Affiliate;
use Closure;

class LastViewed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle ($request, Closure $next)
    {
        $response = $next($request);

        if ( \Session::has('campaign_id') ) {
            $last_view = null;
            $campaign_id = \Session::get('campaign_id');
            if ( \Cookie::has('last_viewed') ) {
                $last_view = \Cookie::get('last_viewed');
                // Remove duplicate campaign id
                $last_view = $last_view->filter(function ($item) use ($campaign_id) {
                    return $item[ 'id' ] != $campaign_id;
                });
                $last_view->push([ 'id' => $campaign_id, 'visited_at' => \Carbon::now()->timestamp ]);
            } else {
                // initial new collection
                $last_view = collect([ [ 'id' => $campaign_id, 'visited_at' => \Carbon::now()->timestamp ] ]);
            }

            // Limit last viewed item = 8
            if ( $last_view->count() > 8 ) {
                // Sort by visited asc then reverse order and slice out for 10
                $last_view = $last_view->sortBy('visited_at')->reverse()->slice(0, 10);
            }
            $response->headers->setCookie(\Cookie::make('last_viewed', $last_view), 1440);
        }
        return $response;
    }
}
