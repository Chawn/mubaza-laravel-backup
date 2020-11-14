<?php
/**
 * Created by PhpStorm.
 * User: execter
 * Date: 12/9/2015 AD
 * Time: 14:18
 */

$factory->define(App\User::class, function ($faker) {
    return [
        'full_name'      => $faker->name,
        'detail'         => $faker->sentence(),
        'username'       => $faker->userName,
        'email'          => $faker->email,
        'password'       => bcrypt('123456'),
        'sex'            => $faker->randomElement([ 'm', 'f' ]),
        'avatar'         => '',
        'provider'       => '',
        'provider_id'    => '',
        'is_social'      => 0,
        'role_id'       => 3,
        'user_status_id' => $faker->randomElement([ 1, 2, 3 ]),
    ];
});