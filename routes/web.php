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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('obat', 'ObatController');
    Route::resource('user', 'UserController');
    Route::resource('pasien', 'PasienController');
    Route::resource('diagnosa', 'DiagnosaController');
    Route::resource('poliklinik', 'PoliklinikController');
    Route::resource('gejala', 'GejalaController');
    Route::resource('satuan', 'SatuanController');
    Route::get('profile', 'UserController@profile');
    Route::put('profile', 'UserController@profileUpdate')->name('user.profile');
    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::put('setting', 'SettingController@update')->name('setting.update');
});
