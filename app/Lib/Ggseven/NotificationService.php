<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 2/4/2016 AD
 * Time: 09:41
 */

namespace App\Lib\Ggseven;


use App\Notification;
use App\NotificationType;
use App\User;

class NotificationService
{
    private $notification_model;
    private $notification_type_model;
    private $user_model;

    public function __construct (Notification $notification_model, NotificationType $notification_type_model, User $user_model)
    {
        $this->notification_model = $notification_model;
        $this->notification_type_model = $notification_type_model;
        $this->user_model = $user_model;
    }

    /**
     * Create notification data
     *
     * @param mixed  $user_id
     * @param string $notification_type_name
     * @param string $message
     * @param string $url
     * @return \App\Notification
     */
    public function create ($user_id, $notification_type_name, $message, $url = '')
    {
        $user = $this->user_model->where('id', $user_id)->first();

        if(!$user) {
            return false;
        }

        $notification_type = $this->notification_type_model->type($notification_type_name)->first();

        return $this->notification_model->create([
            'user_id' => $user->id,
            'notification_type_id' => $notification_type->id,
            'message' => $message,
            'url' => $url
        ]);
    }

    public function all ($user_id = '', $paging  = 10)
    {
        $user = $this->user_model;

        if(!\Auth::user()->check()) {
            return null;
        }
        if($user_id = '') {
            $user = $user->where('id', $user_id);
        } else {
            $user = \Auth::user()->user();
        }
        return $user->notification()->orderBy('id', 'dsc')->take($paging)->get();
    }
    /**
     * Get all unread notify message
     * @param $user_id
     * @return \Illuminate\Support\Collection
     */
    public function unread ($user_id)
    {
        $user = $this->user_model->where('id', $user_id)->first();

        if(!$user) {
            return null;
        }

        return $user->notification()->unread()->get();
    }

    /**
     * Set all unread notify message as read
     * @param $user_id
     * @return null
     */
    public function setRead ($user_id)
    {
        $user = $this->user_model->where('id', $user_id)->first();

        if(!$user) {
            return null;
        }

        return $user->notification()->where('is_read', false)->update([
            'is_read' => true
        ]);
    }

    public function unreadCount ()
    {
        if(!\Auth::user()->check()) {
            return 0;
        }
        return count($this->unread(\Auth::user()->user()->id));
    }
}