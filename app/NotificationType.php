<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    public $timestamps = false;

    public $fillable = [
        'name', 'detail'
    ];

    const USER = 'user';
    const ASSOCIATE = 'associate';

    public function scopeType ($query, $name)
    {
        return $query->whereName($name);
    }

    public function scopeUser ($query)
    {
        return $query->whereName(self::USER);
    }

    public function scopeAssociate ($query)
    {
        return $query->whereName(self::ASSOCIATE);
    }

    public function notification ()
    {
        return $this->hasMany(Notification::class);
    }
}
