<?php namespace App\Http\Controllers;

use App\ProductColor;

class ProductColorController extends Controller {


    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
//		$this->middleware('auth');
    }

    public function getFile($type, $id)
    {
        $color = ProductColor::find($id);

        if(!$color)
        {
            return null;
        }

        if($type == 'front')
        {
            return \Storage::get($color->image_front);
        }

        if($type == 'back')
        {
            return \Storage::get($color->image_back);
        }

        if($type == 'front-thumbnail') {
            return \Storage::get($color->image_front_thmb);
        }

        if($type == 'back-thumbnail')
        {
            return \Storage::get($color->image_back_thmb);
        }


        return null;
    }
}