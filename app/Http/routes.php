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
Route::get('/Leadform/{id}', array('as'=>"Leadform",'uses'=> 'LeadformController@show'));
Route::get('/giftAdTree', array('as' => 'giftData', 'uses' => 'GiftappController@treeJson'));
Route::get('/giftAdd', array('as' => 'giftData', 'uses' => 'GiftappController@index'));



