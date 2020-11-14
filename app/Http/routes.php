<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');

Route::get('/', 'HomeController@index');
Route::get('/{url}.html', ['as' => 'campaign-show', 'uses' => 'CampaignController@showCampaign']);
Route::get('/product/{id}/{affiliate_id?}', 'HomeController@getProduct');
Route::post('report/{user_id}', 'HomeController@postReport');
Route::post('help/contact/save', 'HomeController@postContact');
Route::get('campaign-product', function () {
    return view('campaign.product', [ 'title' => 'campaign product' ]);
});
Route::get('user-dashboard', 'UserController@getUserDashboard');

Route::post('update-user-profile', 'HomeController@postUpdateUserProfile');
Route::get('social-login/{provider}', 'Auth\AuthController@getSocialLogin');
Route::get('login', 'UserController@getLogin');
Route::post('login', 'UserController@postLogin');
Route::get('user/password/reset/{token}', 'UserController@getResetPassword');
Route::post('register', 'Auth\AuthController@postRegister');
Route::get('search/{order?}/{sort?}', 'CampaignController@getSearch');
Route::get('campaigns/{url}', 'SellController@showCampaign');
//Route::get('show/{id}', 'CampaignController@getIndex');
Route::get('order/payment/{order_id?}', 'OrderController@getPayment');
Route::get('user/login', 'UserController@getLogin');
Route::get('user/social-login/{provider}', 'UserController@getSocialLogin');
Route::get('user/forgot-password', 'UserController@getForgotPassword');
Route::group([ 'prefix' => 'user/{id}' ], function () {
    Route::controller('/', 'UserController');
});
Route::post('user/forgot-password', 'UserController@postForgotPassword');
Route::post('user/login', 'UserController@postLogin');
Route::post('user/register', 'UserController@postRegister');
Route::post('user/save-data', 'UserController@postSaveData');
Route::post('user/reset-password', 'UserController@postResetPassword');
Route::get('signup', 'UserController@getSignup');
//Route::get('user/{id}', 'UserController@getIndex');

/* Coupon backend */
Route::controller('backend/coupon', 'CouponsController');
/* End coupon backend */

/* Notification route */
Route::get('set-read-notification', 'UserController@setReadNotification');
/* End notificatio route */
Route::controllers([
    'password' => 'Auth\PasswordController',
    'design' => 'DesignController',
    'backend' => 'BackendController',
    'order' => 'OrderController',
    'help' => 'HelpController',
    'product' => 'ProductController',
    'sell' => 'SellController',
    //    'user' => 'UserController',
    'lang' => 'LangController',
    'campaign' => 'CampaignController',
    'associate' => 'AssociateController',
    'product-color' => 'ProductColorController',
    'campaign-category' => 'CampaignCategoryController',
    'api' => 'ApiController',
    'help' => 'HelpController'
]);

/*
 * Route group for https
 */
//Route::group(['before' => 'force.ssl'], function()
//{
//    Route::get('campaign/{url}', 'SellController@showCampaign');
//});
Route::get('backend/payback', 'BackendController@getPayback');


Route::get('start-campaign', 'SellController@getStartCampaign');
Route::get('new-artist', 'SellController@getNewArtist');
//Route::get('manager', 'UserController@getManagerDashboard');
//Route::get('manager-login', 'UserController@getManagerLogin');
//Route::get('manager/payment-request', 'UserController@getPaymentRequest');
//Route::get('manager/message', 'UserController@getMessage');
//Route::get('manager/sell-report', 'UserController@getSellReport');
//Route::get('manager/profile-setting', 'UserController@getProfileSetting');
//Route::get('manager/edit-campaign', 'UserController@getEditCampaignSample');
//Route::get('manager/design/step1', 'UserController@getStep1');
//Route::get('manager/design/step2', 'UserController@getStep2');
//Route::get('manager/design/step3', 'UserController@getStep3');
//Route::get('manager/design/step4', 'UserController@getStep4');
//Route::get('manager/add-product', 'UserController@getAddProduct');
//Route::get('manager/handbook-design', 'UserController@getHandbookDesign');




Route::get('print-report', function () {
    return view('backend.manufacture.check-list-report');
});
Route::get('new-index', function () {
    return view('.new-index', [ 'title' => 'หน้าแรก' ]);
});
Route::get('backend-login', function () {
    return view('backend.backend-login', [ 'title' => 'เข้าสู่ระบบแบคเอ็น' ]);
});
Route::get('product-new', function () {
    return view('campaign.product-new', [ 'title' => 'แสดงแคมเปญ' ]);
});
Route::get('order-history', function () {
    return view('user_dashboard.order-history', [ 'title' => 'ประวัติการสั่งซื้อ' ]);
});
Route::get('order-history-show', function () {
    return view('user_dashboard.order-history-show', [ 'title' => 'ประวัติการสั่งซื้อ' ]);
});
Route::get('manufacture', function () {
    return view('user_dashboard.manufacture', [ 'title' => 'การผลิตของคุณ' ]);
});
Route::get('backend-manufacture', function () {
    return view('backend.manufacture.index', [ 'title' => 'การผลิต' ]);
});
Route::get('backend-manufacture-detail', function () {
    return view('backend.manufacture.manufacture-detail', [ 'title' => 'รายละเอียดการผลิต' ]);
});
Route::get('backend-produce-detail', function () {
    return view('backend.manufacture.produce-detail', [ 'title' => 'รายละเอียดการผลิต' ]);
});
Route::get('backend-print-customer-address', function () {
    return view('backend.manufacture.print-customer-address', [ 'title' => 'พิมพ์ที่อยู่ลูกค้า' ]);
});
Route::get('backend-print-customer-address-barcode', function () {
    return view('backend.manufacture.print-customer-address-barcode', [ 'title' => 'พิมพ์ที่อยู่ลูกค้า' ]);
});
Route::get('backend-produce-list', function () {
    return view('backend.manufacture.produce-list', [ 'title' => 'ใบรายการผลิต' ]);
});
Route::get('campaign', function () {
    return view('backend.campaign', [ 'title' => 'แคมเปญทั้งหมด' ]);
});
Route::get('backend-campaign', function () {
    return view('backend.campaign.index', [ 'title' => 'แคมเปญทั้งหมด' ]);
});
Route::get('backend-campaign-detail', function () {
    return view('backend.campaign.campaign-detail', [ 'title' => 'รายละเอียดแคมเปญ' ]);
});
Route::get('backend-transport', function () {
    return view('backend.transport.index', [ 'title' => 'การจัดส่ง' ]);
});
Route::get('backend-transport-detail', function () {
    return view('backend.transport.transport-detail', [ 'title' => 'รายละเอียดการจัดส่ง' ]);
});
Route::get('backend-account', function () {
    return view('backend.account.account', [ 'title' => 'รายงานการบัญชี' ]);
});
Route::get('backend-account-income', function () {
    return view('backend.account.income', [ 'title' => 'รายรับ' ]);
});
Route::get('backend-account-expense', function () {
    return view('backend.account.expense', [ 'title' => 'รายจ่าย' ]);
});
Route::get('backend-account-expense-purchase', function () {
    return view('backend.account.expense-purchase', [ 'title' => 'จัดซื้อ' ]);
});
Route::get('backend-payment', function () {
    return view('backend.payment.payment', [ 'title' => 'แจ้งการชำระเงิน' ]);
});
Route::get('backend-payment-order-detail', function () {
    return view('backend.payment.order-detail', [ 'title' => 'รายละเอียดการสั่งซื้อ' ]);
});
Route::get('backend-payment-user-order-history', function () {
    return view('backend.payment.user-order-history', [ 'title' => 'รายละเอียดการสั่งซื้อ' ]);
});
Route::get('backend-editplus-add-supply', function () {
    return view('backend.editplus.add-supply', [ 'title' => 'เพิ่มซัพพลาย' ]);
});
Route::get('backend-editplus-add-shirt-type', function () {
    return view('backend.editplus.add-shirt-type', [ 'title' => 'เพิ่มชนิดเสื้อ' ]);
});
Route::get('backend-editplus-add-shirt-color', function () {
    return view('backend.editplus.add-shirt-color', [ 'title' => 'เพิ่มสีเสื้อ' ]);
});
Route::get('backend-editplus-add-shirt-size', function () {
    return view('backend.editplus.add-shirt-size', [ 'title' => 'เพิ่มขนาดเสื้อ' ]);
});
Route::get('backend-products-show', function () {
    return view('backend.products.show', [ 'title' => 'สินค้า' ]);
});
Route::get('backend-products-edit', function () {
    return view('backend.products.edit', [ 'title' => 'แก้ไขสินค้า' ]);
});
Route::get('backend-mail', function () {
    return view('backend.mail.index', [ 'title' => 'ข้อความ' ]);
});
Route::get('backend-mail-detail', function () {
    return view('backend.mail.mail-detail', [ 'title' => 'รายละเอียดข้อความ' ]);
});
Route::get('forgetpassword', function () {
    return view('auth.forgetpassword', [ 'title' => 'ลืมรหัสผ่าน' ]);
});
Route::get('repassword', function () {
    return view('auth.repassword', [ 'title' => 'ลืมรหัสผ่าน' ]);
});
Route::get('view-user-order', function () {
    return view('user_dashboard.view-user-order', [ 'title' => 'รายละเอียดการสั่งซื้อ' ]);
});
Route::get('view-user-order-print', function () {
    return view('user_dashboard.view-user-order-print', [ 'title' => 'พิมพ์รายละเอียดการสั่งซื้อ' ]);
});
Route::get('view-user-detail', function () {
    return view('user_dashboard.view-user-detail', [ 'title' => 'รายละเอียดการสั่งซื้อ' ]);
});
Route::get('view-campaign', function () {
    return view('user_dashboard.view-campaign', [ 'title' => 'รายละเอียดการขาย' ]);
});


Route::get('error-503', function () {
    return view('errors.error-503', [ 'title' => 'error503' ]);
});
Route::get('error-404', function () {
    return view('errors.error-404', [ 'title' => 'error404' ]);
});


Route::get('user-campaign', function () {
    return view('user_dashboard.user-campaign', [ 'title' => 'การขายของคุณ' ]);
});
Route::get('user-order-history', function () {
    return view('user_dashboard.user-order-history', [ 'title' => 'ประวัติการสั่งซื้อ' ]);
});
Route::get('user-follow', function () {
    return view('user_dashboard.user-follow', [ 'title' => 'การติดตาม' ]);
});
Route::get('user-following', function () {
    return view('user_dashboard.user-following', [ 'title' => 'กำลังติดตาม' ]);
});
Route::get('submenu-user', function () {
    return view('layout.include.submenu-user', [ 'title' => 'การขายของคุณ' ]);
});
Route::get('user-account', function () {
    return view('user_dashboard.user-account', [ 'title' => 'ตั้งค่าบัญชีผู้ใช้' ]);
});
Route::get('user-account-address', function () {
    return view('user_dashboard.user-account-address', [ 'title' => 'ที่อยู่ในการติดต่อ' ]);
});
Route::get('user-account-contact', function () {
    return view('user_dashboard.user-account-contact', [ 'title' => 'การติดต่อ' ]);
});
Route::get('user-account-security/{id}', function () {
    return view('user_dashboard.user-account-security', [ 'title' => 'ตั้งค่าความปลอดภัย' ]);
});
Route::get('user-favorite', function () {
    return view('user_dashboard.user-favorite', [ 'title' => 'ที่ชื่นชอบ' ]);
});

Route::get('user-view', function () {
    return view('user_dashboard.user-view', [ 'title' => 'รายละเอียดผู้ใช้' ]);
});
Route::get('user-campaign-view', function () {
    return view('user_dashboard.user-campaign-view', [ 'title' => 'รายละเอียดการขาย' ]);
});
Route::get('mobile-user-menu/{id}', function ($id) {
    $user = \App\User::find($id);
    return view('user_dashboard.mobile-user-menu', [ 'title' => 'เมนูโมบาย', "user" => $user ]);
});

Route::get('backend-index-produce', function () {
    return view('backend.index-produce', [ 'title' => 'หน้าแรกผู้ผลิต' ]);
});
Route::get('campaign-show', function () {
    return view('campaign.campaign-show', [ 'title' => 'รายละเอียดสินค้า' ]);
});
/*
 * Experimant route
 * TODO::Delete after production for security and performance
 */
Route::get('crypt/{id}', function($id) {
    dd(\PseudoCrypt::hash($id));
});

Route::get('backend-payback-profit-detail', function () {
    return view('backend.payback.profit-detail', [ 'title' => 'รายละเอียดการยื่นขอโอนเงิน' ]);
});

Route::get('backend-payment-history', function () {
    return view('backend.payment.payment-history', [ 'title' => 'การจ่ายรายได้' ]);
});
Route::get('backend-payment-history-detail', function () {
    return view('backend.payment.payment-history-detail', [ 'title' => 'รายละเอียดการจ่ายรายได้' ]);
});
Route::get('backend-payback-profit-detail-print', function () {
    return view('backend.payment.payment-history-detail-print', [ 'title' => 'พิมพ์รายละเอียดการจ่ายรายได้' ]);
});
Route::get('backend-waiting-produce-detail', function () {
    return view('backend.manufacture.waiting-produce-detail', [ 'title' => 'รายละเอียดสินค้ารอดำเนินการ' ]);
});
Route::get('backend-producing-detail', function () {
    return view('backend.manufacture.producing-detail', [ 'title' => 'รายละเอียดสินค้ากำลังดำเนินการ' ]);
});

Route::get('new-search', function () {
    return view('new-search', [ 'title' => 'ค้นหาสินค้า' ]);
});

Route::get('backend-waiting-produce-detail', function () {
    return view('backend.manufacture.waiting-produce-detail', [ 'title' => 'รายละเอียดสินค้ารอดำเนินการ' ]);
});
Route::get('backend-producing-detail', function () {
    return view('backend.manufacture.producing-detail', [ 'title' => 'รายละเอียดสินค้ากำลังดำเนินการ' ]);
});

Route::get('create-admin', function() {
    App\Admin::create(['email' => 'admin@mubaza.com', 'password' => bcrypt('123456')]);
});

Route::get('new-search', function () {
    return view('new-search', [ 'title' => 'ค้นหาสินค้า' ]);
});

Route::get('backend-mail-order-success', function () {
    return view('backend.mail.order-success', [ 'title' => 'อีเมลล์การสั่งซื้อ' ]);
});
Route::get('backend-mail-order-paid', function () {
    return view('backend.mail.order-paid', [ 'title' => 'อีเมลล์ยืนยันการชำระเงิน' ]);
});

Route::get('backend-quotation', function () {
    return view('backend.CRM.quotation.index', [ 'title' => 'ใบเสนอราคา' ]);
});
Route::get('backend-quotation-create', function () {
    return view('backend.CRM.quotation.create', [ 'title' => 'สร้างใบเสนอราคา' ]);
});

Route::get('backend-PO-create', function () {
    return view('backend.CRM.purchase-order.create', [ 'title' => 'สร้างใบสั่งซื้อ' ]);
});

Route::get('backend-document-bulkposting', function () {
    return view('backend.document.bulkposting', [ 'title' => 'ใบรับฝากรวม' ]);
});
Route::get('backend-document-ordered', function () {
    return view('backend.document.ordered', [ 'title' => 'ใบเสร็จ' ]);
});
Route::get('backend-document-production-order', function () {
    return view('backend.document.production-order', [ 'title' => 'ใบสั่งผลิต' ]);
});
Route::get('backend-document-sale-order', function () {
    return view('backend.document.sale-order', [ 'title' => 'ใบขาย' ]);
});

Route::get('design-finish', function () {
    return view('design.finish', [ 'title' => 'ออกแบบเพื่อสั่งซื้อเสร็จแล้ว' ]);
});

Route::get('interview/praseart', function () {
    return view('interview.praseart', [ 'title' => 'สัมภาษณ์คุณเคน' ]);
});

Route::get('new-affiliate', function () {
    return view('sell.new-affiliate', [ 'title' => 'ลงทะเบียนนักขาย' ]);
});
Route::get('associate-artist', function () {
    return view('sell.associate-artist', [ 'title' => 'ร่วมงานในฐานะศิลปิน' ]);
});
Route::get('associate-affiliate', function () {
    return view('sell.associate-affiliate', [ 'title' => 'ร่วมงานในฐานะนักขาย' ]);
});
Route::get('affiliate-createurl', function () {
    return view('sell.associate-affiliate-createurl', [ 'title' => 'สร้าง URL สำหรับนักขาย' ]);
});

Route::get('backend-new-label', function () {
    return view('backend.manufacture.new-label', [ 'title' => 'พิมพ์ที่อยู่ลูกค้า' ]);
});

Route::get('order-tracking', function () {
    return view('order-tracking', [ 'title' => 'ติดตามสถานะการสั่งซื้อ' ]);
});

Route::get('landing-page', function () {
    return view('landing-page', [ 'title' => 'เตรียมพบกับ' ]);
});

Route::get('mail-confirm', function () {
    return view('mail.confirm', [ 'title' => 'ยืนยันการลงทะเบียนทางอีเมลล์' ]);
});

Route::get('mail-registered', function () {
    return view('mail.registered', [ 'title' => 'ลงทะเบียนเสร็จแล้ว' ]);
});
Route::get('mail-order', function () {
    return view('mail.purchase.order', [ 'title' => 'ยืนยันการสั่งซื้อ' ]);
});
Route::get('mail-confirm-order', function () {
    return view('mail.purchase.confirm-order', [ 'title' => 'ยืนยันการชำระเงิน' ]);
});
Route::get('manual-design', function () {
    return view('manager.activity.manual-design', [ 'title' => 'คู่มือการออกแบบลายเสื้อ' ]);
});
//Route::get('coupon', function () {
//    return view('backend.coupon.index', [ 'title' => 'คูปองทั้งหมด' ]);
//});
//Route::get('coupon-add', function () {
//    return view('backend.coupon.add', [ 'title' => 'สร้างคูปอง' ]);
//});
//Route::get('coupon-edit', function () {
//    return view('backend.coupon.edit', [ 'title' => 'แก้ไขคูปอง' ]);
//});
//Route::get('coupon-view', function () {
//    return view('backend.coupon.view', [ 'title' => 'ดูรายละเอียดคูปอง' ]);
//});
Route::get('guide/create-art', function () {
    return view('manager.guide.create-art', [ 'title' => 'คู่มือออกแบบลายเสื้อ' ]);
});
/*
 * Coupon routes
 */

//Route::get('backend/coupons/store', 'CouponsController@store');
//Route::get('coupon/create', 'CouponsController@create');
//
//Route::put('coupon/store', 'CouponsController@store');
//
//Route::get('coupon/edit/{id}', 'CouponsController@edit')->where('id', '[0-9]+');
//
//Route::post('coupon/update/{id}', 'CouponsController@update')->where('id', '[0-9]+');
//
//Route::post('coupon/api/check', 'CouponsController@apiCheck');
//
//Route::delete('coupon/delete/{id}', 'CouponsController@destroy')->where('id', '[0-9]+');
//
//Route::get('coupon/', 'CouponsController@couponList');
//
//Route::get('coupon/detail/{id}', 'CouponsController@couponDetail')->where('id', '[0-9]+');
//
//Route::get('checkout/order', 'CheckoutController@checkoutOrder')->where('id', '[0-9]+');
//
//Route::post('checkout/order', 'CheckoutController@checkoutOrder')->where('id', '[0-9]+');
//
//Route::post('checkout/submit/order', 'CheckoutController@checkoutSubmit');
//
//Route::get('checkout/success/order/{id}', 'CheckoutController@checkoutSuccess')->where('id', '[0-9]+');
/*
 * End coupon routes
 */


Route::get('collection', function () {
    return view('collection.collection', [ 'title' => 'คอเล็คชั่น' ]);
});
Route::get('collection-create', function () {
    return view('manager.collection-create', [ 'title' => 'สร้างคอเล็คชั่น' ]);
});
Route::get('store-create', function () {
    return view('manager.store-create', [ 'title' => 'สร้างสโตร์' ]);
});
Route::get('manager-store', function () {
    return view('manager.store', [ 'title' => 'สโตร์ของฉัน' ]);
});
Route::get('store', function () {
    return view('store', [ 'title' => 'สโตร์' ]);
});
Route::get('count-tag', function() {
    \CampaignService::topTag();
});