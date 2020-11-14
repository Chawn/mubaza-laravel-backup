<?php namespace App\Http\Middleware;

use Closure;

class Lang {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(\Session::has('locale'))
        {
            \Session::put('locacle', \Config::get('app.locale'));
        }
        app()->setLocale(\Session::get('locale'));
		return $next($request);
	}

}
