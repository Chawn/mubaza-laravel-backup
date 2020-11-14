<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CommissionRateTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('commission_rates')->delete();

        App\CommissionRate::create(['min' => 0, 'max' => 99999, 'percent' => 13, 'active' => true]);
//        App\CommissionRate::create(['min' => 11, 'max' => 20, 'percent' => 10, 'active' => true]);
//        App\CommissionRate::create(['min' => 21, 'max' => 50, 'percent' => 12, 'active' => true]);
//        App\CommissionRate::create(['min' => 51, 'max' => 99999, 'percent' => 15, 'active' => true]);
    }
}
