<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CampaignTableSeeder extends Seeder {

    public function run()
    {
//        DB::table('campaigns')->delete();
//        for($i = 1;$i <= rand(5, 20);$i++) {
//            $user = TestDummy::create('App\User');
//            TestDummy::create('App\UserProfile', ['id' => $user->id]);
//            TestDummy::create('App\UserOption', ['id' => $user->id]);
//            for($x = 1; $x <= rand(5, 20); $x++) {
//                $campaign_design = TestDummy::create('App\CampaignDesign');
//                $campaign = TestDummy::create('App\Campaign', ['campaign_design_id' => $campaign_design->id, 'user_id' => $user->id]);
//                TestDummy::create('App\CampaignText', ['campaign_design_id' => $campaign_design->id]);
//                $campaign_product = TestDummy::create('App\CampaignProduct', ['campaign_id' => $campaign->id]);
//                $orders = TestDummy::times(10)->create('App\Order', ['campaign_id' => $campaign->id, 'user_id' => $user->id]);
//                foreach ($orders as $index => $order) {
//                    TestDummy::create('App\Payment', ['order_id' => $order->id]);
//                    TestDummy::times(2)->create('App\OrderItem', ['order_id' => $order->id, 'campaign_product_id' => $campaign_product->id]);
//                }
//            }
//        }
    }

}