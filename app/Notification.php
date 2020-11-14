<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $fillable = [
        'message',
        'notification_type_id',
        'user_id',
        'is_read',
        'url'
    ];

    public function scopeUnread ($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead ($query)
    {
        return $query->where('is_read', true);
    }

    public function type ()
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }

    public function user ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
