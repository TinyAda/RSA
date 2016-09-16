<?php
return [

	/*
	|--------------------------------------------------------------------------
	| Config Language
	|--------------------------------------------------------------------------
	|
	| Here you can config your yunpian api key from yunpian provided.
	|
	| Options: ['zh-cn', 'zh-tw', 'en', 'ja', 'ko']
	|
	*/
	'lang' => 'zh-cn',

	/*
	|--------------------------------------------------------------------------
	| Config Geetest Id
	|--------------------------------------------------------------------------
	|
	| Here you can config your yunpian api key from yunpian provided.
	|
	*/
	'private_exp' => env('RSA_PRIVATE_EXP'),

	/*
	|--------------------------------------------------------------------------
	| Config Geetest Key
	|--------------------------------------------------------------------------
	|
	| Here you can config your yunpian api key from yunpian provided.
	|
	*/
	'public_exp' => env('RSA_PUBLIC_EXP'),

	/*
	|--------------------------------------------------------------------------
	| Config Geetest URL
	|--------------------------------------------------------------------------
	|
	| Here you can config your geetest url for ajax validation.
	|
	*/
	'modulus' => env('RSA_MODULUS'),

];