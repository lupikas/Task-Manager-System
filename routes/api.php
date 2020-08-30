<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {
  Route::get('user', 'UserController@getAuthenticatedUser');
  Route::post('createtask', 'TaskController@store');
  Route::get('mytasks', 'TaskController@index');
  Route::post('/task/{task}/update', 'TaskController@update');
  Route::post('/task/{task}/delete', 'TaskController@delete');
  Route::get('/task/{task}', 'TaskController@view');
  Route::post('/task/{task}/createmessage', 'MessageController@createMessage');
  Route::post('/task/{task}/message/{message}/update', 'MessageController@updateMessage');
  Route::post('/task/{task}/message/{message}/delete', 'MessageController@deleteMessage');
  Route::post('/task/{task}/view/{message}', 'MessageController@viewMessage');
  Route::get('/viewlog', 'MessageController@viewMessageLog');
});
