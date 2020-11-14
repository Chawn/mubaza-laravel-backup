<?php
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        App\Role::create(['name' => 'Administrator']);
        App\Role::create(['name' => 'User']);
    }

}