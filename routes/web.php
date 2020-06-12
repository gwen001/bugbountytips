<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('home')->get('/', function () {
    return view('home');
});

// Route::view('admin', 'back.layout');

Route::name('login')->get('login', 'Auth\LoginController');
Route::name('login')->post('login', 'Auth\LoginController@login');

Route::prefix('admin')->middleware('admin')->namespace('Back')->group(function () {
    Route::name('admin')->get('/', 'AdminController@index');
    Route::name('tweet.update')->put('tweets/update', 'TweetController@update');
    Route::name('tweet.ignore')->get('tweets/ignore/{tweet}', 'TweetController@ignore');
    Route::name('tweet.unignore')->get('tweets/unignore/{tweet}', 'TweetController@unignore');
    Route::name('tweet.destroy')->get('tweets//destroy/{tweet}', 'TweetController@destroy');
    Route::resource('tweets', 'TweetController')->except('show')->parameters([
        'tweet' => 'tweet'
      ]);
});

// Route::get('grab/{tweet?}', function ($tweet=NULL) {
//     Artisan::queue('tweet:grab', ['tweet'=>$tweet]);
// });
