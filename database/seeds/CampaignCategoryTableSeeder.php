<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CampaignCategoryTableSeeder extends Seeder
{

    public function run ()
    {
        DB::table('campaign_categories')->delete();
        App\CampaignCategory::create([ 'name' => 'sport', 'detail' => 'กีฬา' ]);
        App\CampaignCategory::create([ 'name' => 'work-out', 'detail' => 'การออกกำลังกาย' ]);
        App\CampaignCategory::create([ 'name' => 'automotive', 'detail' => 'เครื่องยนต์' ]);
        App\CampaignCategory::create([ 'name' => 'travel', 'detail' => 'ท่องเที่ยว' ]);
        App\CampaignCategory::create([ 'name' => 'drinking', 'detail' => 'นักดื่ม' ]);
        App\CampaignCategory::create([ 'name' => 'pet', 'detail' => 'สัตว์เลี้ยง' ]);
        App\CampaignCategory::create([ 'name' => 'funny', 'detail' => 'ตลก สนุกสนาน' ]);
        App\CampaignCategory::create([ 'name' => 'technology', 'detail' => 'เทคโนโลยี' ]);
        App\CampaignCategory::create([ 'name' => 'celebrate', 'detail' => 'เทศกาล วันพิเศษ' ]);
        App\CampaignCategory::create([ 'name' => 'occupation', 'detail' => 'อาชีพ' ]);
        App\CampaignCategory::create([ 'name' => 'animal', 'detail' => 'สัตว์' ]);
        App\CampaignCategory::create([ 'name' => 'word', 'detail' => 'คำคม' ]);
        App\CampaignCategory::create([ 'name' => 'movie', 'detail' => 'ภาพยนตร์' ]);
        App\CampaignCategory::create([ 'name' => 'music', 'detail' => 'เพลง' ]);
        App\CampaignCategory::create([ 'name' => 'game', 'detail' => 'เกม' ]);
        App\CampaignCategory::create([ 'name' => 'cartoon', 'detail' => 'การ์ตูน' ]);
        App\CampaignCategory::create([ 'name' => 'sweet', 'detail' => 'หวานแหวว' ]);
        App\CampaignCategory::create([ 'name' => 'retro', 'detail' => 'ย้อนยุค' ]);
        App\CampaignCategory::create([ 'name' => 'innovate', 'detail' => 'แปลกแหวกแนว' ]);
        App\CampaignCategory::create([ 'name' => '3D', 'detail' => '3D' ]);
//        App\CampaignCategory::create([ 'name' => 'Automotive', 'detail' => 'Automotive', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Camping', 'detail' => 'Camping', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Drinking', 'detail' => 'Drinking', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Faith', 'detail' => 'Faith', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Fishing', 'detail' => 'Fishing', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Fitness', 'detail' => 'Fitness', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Funny', 'detail' => 'Funny', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Geek', 'detail' => 'Geek', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Holidays', 'detail' => 'Holidays', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Hunting', 'detail' => 'Hunting', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'LifeStyle', 'detail' => 'LifeStyle', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Movies', 'detail' => 'Movies', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Music', 'detail' => 'Music', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Pets', 'detail' => 'Pets', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Political', 'detail' => 'Political', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Sports', 'detail' => 'Sports', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'TV ', 'detail' => 'TV ', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Video ', 'detail' => 'Video ', 'is_active' => true ]);
//        App\CampaignCategory::create([ 'name' => 'Zombies', 'detail' => 'Zombies', 'is_active' => true ]);
    }

}