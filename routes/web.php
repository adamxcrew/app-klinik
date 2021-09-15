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
    return redirect('login');
});
Auth::routes();
Route::middleware(['auth'])->group(function () {

    Route::get('pendaftaran', 'PendaftaranController@index')->name('pendaftaran.index');
    Route::get('pendaftaran/{id}/detail', 'PendaftaranController@detail')->name('pendaftaran.detail');
    Route::get('pendaftaran/{id}/cetak', 'PendaftaranController@cetak')->name('pendaftaran.cetak');
    Route::get('pendaftaran/{id}/print', 'PendaftaranController@print')->name('pendaftaran.print');
    Route::delete('pendaftaran/{id}', 'PendaftaranController@destroy')->name('pendaftaran.delete');

    Route::get('data-diagnosa', 'PendaftaranController@dataDiagnosa')->name('data.diagnosa');
    Route::get('data-tindakan', 'PendaftaranController@dataTindakan')->name('data.tindakan');
    Route::get('data-obat', 'PendaftaranController@dataObat')->name('data.obat');

    Route::get('pendaftaran/create', 'PendaftaranController@pendaftaranCreate')->name('pendaftaran.pasien-terdaftar');
    Route::post('detail-pasien', 'PendaftaranController@detailPasien')->name('pasien.detail');
    Route::post('pendaftaran/insert', 'PendaftaranController@pendaftaranInsert')->name('pendaftaran.insert');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('obat', 'ObatController');
    Route::resource('user', 'UserController');
    Route::resource('pasien', 'PasienController');
    Route::resource('diagnosa', 'DiagnosaController');
    Route::resource('poliklinik', 'PoliklinikController');
    Route::resource('gejala', 'GejalaController');
    Route::resource('satuan', 'SatuanController');
    Route::resource('tindakan', 'TindakanController');
    Route::resource('akun', 'AkunController');
    Route::resource('jurnal', 'JurnalController');
    Route::resource('gaji', 'GajiController');
    Route::resource('pegawai', 'PegawaiController');
    Route::resource('asuransi', 'AsuransiController');
    Route::get('profile', 'UserController@profile');
    Route::put('profile', 'UserController@profileUpdate')->name('user.profile');
    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::put('setting', 'SettingController@update')->name('setting.update');
    Route::get('ajax/dropdown-dokter-berdasarkan-poliklinik', 'AjaxController@dropdownDokterBerdasarkanPoliklinik');
    Route::get('ajax/select2Desa', 'AjaxController@select2Desa');
});
