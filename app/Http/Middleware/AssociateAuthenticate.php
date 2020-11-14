<?php

namespace App\Http\Middleware;

use App\AssociateStatus;
use Closure;

class AssociateAuthenticate
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
        if ( \Auth::user()->check() && \Auth::user()->user()->isAssociate() ) {
            if(\Auth::user()->user()->affiliate->status->name == AssociateStatus::ACTIVE) {
                return $next($request);
            }

            return view('errors.user-banned');
        } else {
            return redirect()->guest('associate/');
        }
    }
}
