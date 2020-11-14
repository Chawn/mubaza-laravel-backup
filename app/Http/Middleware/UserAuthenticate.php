<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserAuthenticate {

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
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
		if (\Auth::user()->check())
		{
			if(\Auth::user()->user()->status->name != 'banned') {
				return $next($request);
			}

			\Auth::user()->logout();
			return view('errors.user-banned');
        } else {
            return redirect()->guest('user/login');
        }

    }

}
