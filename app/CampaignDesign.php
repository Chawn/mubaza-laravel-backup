<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignDesign extends Model {

    public $fillable = [
        'front_design', 'back_design',
        'block_front_count','block_back_count',
        'block_front_color','block_back_color',
        'image_front', 'image_back',
        'image_front_preview', 'image_back_preview',
        'image_front_preview_thmb', 'image_back_preview_thmb',
    ];

    /**
     * @param $attr
     * @return string
     */
//    public function getImageFrontPreviewAttribute($attr) {
//        return url('/') . '/' . $attr;
//    }

    /**
     * @param $attr
     * @return string
     */
    public function getImageBackPreviewAttribute($attr) {
        return url('/') . '/' . $attr;
    }
    public function getImageFrontAttribute($attr) {
        if ($attr!="") {
            return $attr;
        }
        return "";
    }
    public function getImageBackAttribute($attr) {
        if ($attr!="") {
            return $attr;
        }
        return "";
    }

    public function getImageFront() {
        return is_null($this->image_front_preview) ? null : explode('storage', $this->image_front_preview)[1];
    }
    public function getImageBack() {
        return is_null($this->image_back_preview) ? null :  explode('storage', $this->image_back_preview)[1];
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns() {
        return $this->hasMany('App\Campaign');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures() {
        return $this->hasMany('App\CampaignPicture');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function texts() {
        return $this->hasMany('App\CampaignText');
    }
}
