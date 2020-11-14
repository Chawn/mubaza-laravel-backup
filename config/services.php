<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],
    'github' => [
        'client_id' => '84c937437f4c335cae03',
        'client_secret' => '6632c4d9a7a17f7f3d5579c6c8f643ce4cfa260a',
        'redirect' => 'http://localhost/mubaza-laravel/public',
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', '626433700800712'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '3bc7c540ff2cda94cbc5be0aaf32ce7e'),
        'redirect' => env('FACEBOOK_REDIRECT', 'http://beta.mubaza.com/user/social-login/facebook'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '319353459671-58b65ibkhr5iso77j1pga5o0ladfjr4c.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'OkgIm--XlAEAdVLz0H5yRHQM'),
        'redirect' => env('GOOGLE_REDIRECT', 'http://beta.mubaza.com/user/social-login/google'),
    ],
];