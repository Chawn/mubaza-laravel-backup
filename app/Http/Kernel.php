<?php namespace App\Http;

use App\Http\Middleware\AssociateAuthenticate;
use App\Http\Middleware\ClickStat;
use App\Http\Middleware\LastViewed;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
//		'App\Http\Middleware\VerifyCsrfToken',
        'App\Http\Middleware\VerifyCsrf',
        'App\Http\Middleware\Lang',
       //'App\Http\Middleware\Secure'
       'App\Http\Middleware\ClickStat',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'userauth' => 'App\Http\Middleware\UserAuthenticate',
		'admin.auth' => 'App\Http\Middleware\AdminAuthenticate',
		'designer.auth' => 'App\Http\Middleware\DesignerAuthenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'view_count' => 'App\Http\Middleware\ViewCount',
		'click_stat' => ClickStat::class,
		'last_viewed' => LastViewed::class,
		'associate.only' => AssociateAuthenticate::class
	];

}