<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App;

class LangController extends Controller {

	public function getChangeLanguage($lang, $redirect) {
        \Session::put('locale', $lang);

        return redirect::intent ($redirect);
    }

}
