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

Route::get('/', function () {
    return view('giftIndex');
});
Route::get('/error', function () {
    return view('error');
});
Route::get('/giftAdTree', array('as' => 'giftData', 'uses' => 'GiftappController@treeJson'));
Route::get('/giftAdd/{category}', array('as' => 'giftData', 'uses' => 'GiftappController@index'));

Route::get('/FacebookLogin', array('as'=>"FacebookLogin",'uses'=> 'FacebookController@facebooklogin'));
Route::get('/FacebookUser', array('as'=>"FacebookUser",'uses'=> 'FacebookController@facebookuser'));

