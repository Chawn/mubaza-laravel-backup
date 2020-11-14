<?php
//$factory('App\CampaignDesign', [
//    'block_front_count' => $faker->randomElement([1,2,3]),
//    'block_back_count' => $faker->randomElement([1,2,3]),
//    'block_front_color' => '',
//    'block_back_color' => '',
//    'image_front' => '',
//    'image_back' => '',
//    'image_front_preview' => '',
//    'image_back_preview' => '',
//]);
//$factory->define('App\Campaign', function(Faker\Generator $faker) {
//    return [
//        'title'                       => $faker->sentence(),
//        'description'                 => $faker->paragraph(),
//        'goal'                        => $faker->randomElement([10, 20, 30, 40, 50, 100, 200]),
//        'url'                         => $faker->sentence(),
//        'back_cover'                  => $faker->randomElement([1, 0, 0, 0]),
//        'end_amount'                  => $faker->randomElement([3, 5, 7, 21]),
//        'start'                       => $faker->dateTime(),
//        'end'                         => $faker->dateTime(),
//        'campaign_design_id'          => 'factory:App\CampaignDesign',
//        'campaign_type_id'            => 1,
//        'campaign_status_id'          => $faker->randomElement([1, 2, 3]),
//        'campaign_produce_status_id'  => $faker->randomElement([1, 2, 3, 4]),
//        'user_id'                     => 'factory:App\User'
//    ];
//});
//
//$factory('App\CampaignText', [
//    'item_no'     => $faker->randomDigitNotNull,
//    'text'        => $faker->word,
//    'color'       => $faker->hexcolor,
//    'size'        => $faker->randomElement([15, 17, 19, 21, 23, 25, 27, 29, 31]),
//    'family'      => $faker->randomElement(['Tahoma', 'San Serif']),
//    'location'    => $faker->randomElement(['front', 'back']),
//    'left'        => $faker->randomElement([5, 10, 15, 20, 25, 30]),
//    'top'         => $faker->randomElement([5, 10, 15, 20, 25, 30]),
//    'rotate'      => '0',
//    'z_index'     => $faker->randomElement([1, 2, 3, 4, 5]),
//    'campaign_design_id' => 'factory:App\CampaignDesign',
//]);
//
//$factory('App\CampaignProduct', [
//    'campaign_id'      => 'factory:App\Campaign',
//    'product_id'       => $faker->randomElement([1, 2, 3]),
//    'product_image_id' => $faker->randomElement([1, 2, 3]),
//    'sell_price'       => $faker->randomElement([350, 360, 370, 380, 390, 400, 410, 420, 430, 440, 450]),
//    'min_price'        => $faker->randomElement([200, 220, 240, 260, 280, 300, 320, 340]),
//]);
//
//$factory('App\Order', [
//    'user_id'            => 'factory:App\User',
//    'order_status_id'    => $faker->randomElement([1, 2, 3]),
//    'campaign_id'        => 'factory:App\Campaign',
//    'shipping_type_id'   => 1,
//    'shipping_status_id' => $faker->randomElement([1, 2]),
//    'payment_type_id'    => $faker->randomElement([1, 2]),
//    'payment_status_id'  => $faker->randomElement([1, 2, 3]),
//]);
//$factory('App\Payment', [
//    'total' => $faker->randomElement([0, 1000, 2000, 1500]),
//    'pay_on' => $faker->dateTime(),
//    'transaction_id' => '',
//    'from_bank' => $faker->randomelement(['กสิกรไทย', 'กรุงเทพ', 'กรุงไทย', 'กรุงศรี']),
//    'to_bank' => $faker->randomelement(['กสิกรไทย', 'กรุงเทพ', 'กรุงไทย', 'กรุงศรี']),
//    'order_id' => 'factory:App\Order',
//]);
//$factory('App\OrderItem', [
//    'qty'                 => $faker->randomDigit,
//    'size'                => $faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
//    'order_id'            => 'factory:App\Order',
//    'campaign_product_id' => 'factory:App\CampaignProduct',
//]);
//$factory('App\UserOption', [
//   'id' => 'factory:App\User'
//]);
//
//$factory('App\UserProfile', [
//   'id' => 'factory:App\User'
//]);

$factory->define(App\User::class, function($faker) {
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
