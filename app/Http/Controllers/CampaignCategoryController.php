<?php namespace App\Http\Controllers;

use App\CampaignCategory;

class CampaignCategoryController extends Controller {

    public function getAll()
    {
        return response()->json(CampaignCategory::all());
    }
}