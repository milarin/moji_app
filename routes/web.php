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

Route::get('/characters', 'CharacterController@index')->name('chara.list');
Route::get('/character/new', 'CharacterController@create')->name('chara.new');
Route::post('/character', 'CharacterController@store')->name('chara.store');
Route::get('/character/edit/{id}', 'CharacterController@edit')->name('chara.edit');
Route::post('/character/update/{id}', 'CharacterController@update')->name('chara.update');

Route::get('/character/{id}', 'CharacterController@show')->name('chara.detail');
Route::delete('/character/{id}', 'CharacterController@destroy')->name('chara.destroy');

Route::get('/profile/{id}', 'UserController@index')->name('user.detail');
Route::get('/profile/edit/{id}', 'UserController@edit')->name('user.edit');
Route::post('/profile/update/{id}', 'UserController@update')->name('user.update');

Route::get('/', function () {
    return redirect('/characters');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

