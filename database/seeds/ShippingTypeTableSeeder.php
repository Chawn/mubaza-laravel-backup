<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ShippingTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('shipping_types')->delete();

        App\ShippingType::create(['name' => 'registered',
                                  'detail' => 'การจัดส่งสินค้าทางไปรษณีย์แบบลงทะเบียน']);
        App\ShippingType::create(['name' => 'ems',
                                  'detail' => 'การจัดส่งสินค้าทางไปรษณียแบบ EMS']);
        App\ShippingType::create(['name' => 'kerry',
                                  'detail' => 'Kerry Express']);
    }

}