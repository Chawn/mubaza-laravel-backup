<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public $fillable = [
        'name', 'url', 'detail', 'cover_image', 'user_id', 'private'
    ];

    public function scopePrivate($query)
    {
        return $query->where('private', true);
    }

    /**
     * Create new url for collection
     * @param $name
     * @return mixed|string
     * @internal param $title
     */
    public static function createUrl($name)
    {
        $url = preg_replace("/[&\\/\\\\\\[\\]#,+()$~%.'\":*?<>{}]/", "", trim($name));
        $url = str_replace(" ", "-", $url);
        $collection = Collection::whereName($name)->get();

        if ($collection->count() <= 0) {
            return $url;
        }

        return $url . '-' . ($collection->count() + 1);
    }

    public function items()
    {
        return $this->hasMany('App\CollectionItem');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
