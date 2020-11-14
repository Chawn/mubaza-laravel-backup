<?php namespace App\Http\Middleware;

use Closure;

class ViewCount {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$path = explode('/', $request->path());

		if(count($path) == 2) {
			if (\Auth::user()->check()) {
				if (!\Auth::user()->user()->isOwnerByUrl($path[1])) {
					\App\ViewCount::add(session()->getId(), $request->path());
				}
			} else
			{
				\App\ViewCount::add(session()->getId(), $request->path());
			}
		}

		return $next($request);
	}

}
