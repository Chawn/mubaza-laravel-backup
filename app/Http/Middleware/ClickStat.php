<?php

namespace App\Http\Middleware;

use App\Affiliate;
use Closure;

class ClickStat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // If have affiliate id save click statistic to db and set cookie
        if($request->has('affid')) {
            $affiliate_id = $request->get('affid');
            $affiliate = Affiliate::find($affiliate_id);
            if($affiliate) {
                $data = [
                    'method'       => $request->getMethod(),
                    'source'       => $request->server('HTTP_REFERER'),
                    'client_ip'    => $request->getClientIp(),
                    'agent'        => $request->server('HTTP_USER_AGENT'),
                    'landing_page' => $request->url(),
                    'query_string' => $request->getQueryString(),
                    'affiliate_id' => $affiliate->id,
                    'request_time' => \Carbon::now()->toDateTimeString()
                ];

                $click_stat = \App\ClickStat::create($data);

                // Set cookie for affiliate 360 minutes = 6 Hrs
                $response->headers->setCookie(\Cookie::make('aff_id', $click_stat->affiliate_id, config('constant.affiliate_cookie_expired')));
                $response->headers->setCookie(\Cookie::make('aff_cs_id', $click_stat->id, config('constant.affiliate_cookie_expired')));
                $response->headers->setCookie(\Cookie::make('aff_last_update', \Carbon::now()->timestamp, config('constant.affiliate_cookie_expired')));
            }
        }

        return $response;
    }
}
