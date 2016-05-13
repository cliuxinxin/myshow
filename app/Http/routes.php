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
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/shows','ShowsController@index');
Route::get('/shows/spider','ShowsController@spider');
Route::get('/shows/follow/{show}','ShowsController@follow');

//Route::get('/test', function() {
//    $crawler = Goutte::request('GET', 'http://duckduckgo.com/?q=Laravel');
//    $url = $crawler->filter('.result__title > a')->first()->attr('href');
//    dump($url);
//    return view('welcome');
//});