<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminAuthenticate {

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return voidz
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
		if (\Auth::admin()->check())
		{
            return $next($request);
        } else {
            return redirect()->guest('backend/login');
        }

    }

}
