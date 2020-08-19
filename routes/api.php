<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/passwordcheck','Auth\UserController@passwordCheck');
Route::get('/user/duppasswordcheck','Auth\UserController@dupPasswordCheck');
Route::get('/user/dupdoqusercheck','Auth\UserController@dupDoqUserCheck');
Route::post('/group/changedata', 'GroupController@changedata');
Route::post('/user/changeDisplayName', 'Auth\UserController@changeDisplayName');
Route::post('/user/aptitude', 'Auth\UserController@aptitude');
Route::post('/user/updateWishDate', 'Auth\UserController@updateWishDate');


//Route::post("/login", 'Auth\UserController@loginPostAPI'); 				///////////////////////
Route::post('/mobile/bookssearch', 'BookController@bookSearchAPI');  	///////////////////////
Route::post('/mobile/myPage', 'MessageController@messageAPI');			///////////////////////
Route::post('/mobile/searchBooks', 'BookController@bookSearchAPI');		///////////////////////
Route::post('/mobile/registerBooks', 'BookController@booksRegisterAPI');///////////////////////
Route::post('/mobile/registerQus', 'QuizController@registerQusAPI');	///////////////////////
Route::post('/mobile/receiveQus', 'QuizController@receiveQusAPI');		///////////////////////
