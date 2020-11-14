<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 1/12/2016 AD
 * Time: 16:42
 */

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Lib\Ggseven\Backend\BackendService;

class BackendNotifyComposer
{
    protected $backend_service;

    /**
     * Create a new profile composer.
     *
     * @internal param UserRepository $users
     * @param BackendService $backend_service
     */
    public function __construct(BackendService $backend_service)
    {
        $this->campaign_service = $backend_service;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('payment_update_count', \BackendService::paymentUpdateCount());
        $view->with('wait_produce_count', \BackendService::waitProduceCount());
        $view->with('producing_count', \BackendService::producingCount());
        $view->with('wait_transport_count', \BackendService::waitTransportCount());
    }
}