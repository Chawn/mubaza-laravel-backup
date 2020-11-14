<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class DesignerAuthenticate {

    /**
     * Create a new filter instance.
     *
     * @internal param Guard $auth
     */
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->check() && (\Auth::user()->user()->is_designer || \Auth::user()->user()->is_affiliate))
        {
            return $next($request);
        } else {
            return redirect()->guest('associate/');
        }

    }

}
