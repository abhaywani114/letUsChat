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
// Auth::routes();

Route::get('/',"user_management@show_startup_page")->middleware('guest')->name('start_up_page');

Route::post('/signup',"user_management@sign_up")->middleware('guest')->name('register');

Route::post('/login',"user_management@login")->middleware('guest')->name('login');

Route::get('/logout',"user_management@logout")->name('logout');

Route::get('/chat', function () {
    return view('chat_app');
})->middleware('auth');

Route::resource('texts', 'TextsController')->middleware('auth')->except(['show','destroy']);
Route::post('texts/show','TextsController@show')->middleware('auth')->name('texts.show');
Route::post('texts/show_new','TextsController@new_inbox_texts')->middleware('auth')->name('texts.show_new');
Route::post('texts/search_user','TextsController@search_user')->middleware('auth')->name('texts.search_user');
Route::post('texts/delete','TextsController@destroy')->middleware('auth')->name('texts.destroy');