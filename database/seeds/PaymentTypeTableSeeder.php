<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class PaymentTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('payment_types')->delete();

        App\PaymentType::create(['name' => 'transfer', 'detail' => 'โอนเงินธนาคาร']);
        App\PaymentType::create(['name' => 'card', 'detail' => 'บัตรเครดิตหรือบัตรเดบิต']);
    }

}