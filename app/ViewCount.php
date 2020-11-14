<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewCount extends Model {

    public $fillable = [
        'path_id', 'session_id'
    ];
	//
    public static function add($session_id, $route_path)
    {
        $session = \App\ViewSession::firstOrCreate(['session_id' => $session_id]);
        $path = \App\ViewPath::firstOrCreate(['path' => $route_path]);

        \App\ViewCount::create([
            'path_id' => $path->id,
            'session_id' => $session->id
        ]);
    }

    public static function count($route_path)
    {
        $path = \App\ViewPath::wherePath($route_path)->first();
        if($path) {
            $hit_counter = \DB::table('view_counts')
                ->select(\DB::raw('DISTINCT(session_id)'))
                ->where('path_id', $path->id)
                ->get();
            return count($hit_counter);
        }

        return 0;
    }

    public function sessions()
    {
        return $this->belongsTo('view_sessions', 'session_id');
    }

    public function paths()
    {
        return $this->belongsTo('view_paths', 'path_id');
    }
}
