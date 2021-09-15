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
    Route::get('pasien/{id}/diagnosa', 'PasienController@pasienDiagnosa')->name('pasien.diagnosa');
    Route::get('data-tindakan', 'PasienController@dataTindakan')->name('data.tindakan');
    Route::get('data-obat', 'PasienController@dataObat')->name('data.obat');
    Route::get('pasien-antri', 'PasienController@pasienAntri')->name('pasien.antri');
    Route::get('pasien-antri/{id}/detail', 'PasienController@pasienDetail')->name('pasien.detail');
    Route::get('pasien-antri/{id}/cetak', 'PasienController@pasienCetak')->name('pasien.cetak');
    Route::delete('pasien-antri/{id}', 'PasienController@pasienDelete')->name('pasien.delete');
    Route::get('pasien/antrian', 'PasienController@pasienAntrian')->name('pasien.antrian');
    Route::get('pasien/antrian/{id}/cetak', 'PasienController@pasienAntrianCetak')->name('pasien.cetak');

    Route::get('pasien/pasien-terdaftar', 'PasienController@pasienTerdaftar')->name('pasien.terdaftar');
    Route::post('detail-pasien', 'PasienController@detailPasien')->name('pasien.detail');
    Route::post('pasien/pasien-terdaftar/insert', 'PasienController@pasienInsert')->name('pasien.insert');

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
