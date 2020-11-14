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

class FrontendNotifyComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('unread_notification_count', \NotificationService::unreadCount());
        $view->with('user_notifications', \NotificationService::all());
        $view->with('top_tags', \CampaignService::topTag());
    }
}