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

    // route master pendaftaran
    Route::get('pendaftaran'             , 'PendaftaranController@index')->name('pendaftaran.index');
    Route::get('pendaftaran/{id}/detail' , 'PendaftaranController@detail')->name('pendaftaran.detail');
    Route::get('pendaftaran/{id}/cetak'  , 'PendaftaranController@cetak')->name('pendaftaran.cetak');
    Route::get('pendaftaran/{id}/print'  , 'PendaftaranController@print')->name('pendaftaran.print');
    Route::delete('pendaftaran/{id}'     , 'PendaftaranController@destroy')->name('pendaftaran.delete');

    // route pendaftaran pasien yang sudah pernah terdaftar
    Route::get('pendaftaran/create'  , 'PendaftaranController@pendaftaranCreate')->name('pendaftaran.pasien-terdaftar');
    Route::post('detail-pasien'      , 'PendaftaranController@detailPasien')->name('pasien.detail');
    Route::post('pendaftaran/insert' , 'PendaftaranController@pendaftaranInsert')->name('pendaftaran.insert');

    // route menampilkan data diagnosa, resep dan tindakan yang dipilih
    Route::get('resume/diagnosa' , 'PendaftaranController@resumeDiagnosa')->name('resume.diagnosa');
    Route::get('resume/resep'    , 'PendaftaranController@resumeResep')->name('resume.resep');
    Route::get('resume/tindakan' , 'PendaftaranController@resumeTindakan')->name('resume.tindakan');

    // pilih dan hapus pendaftaran resume diagnosa
    Route::post('resume/diagnosa/pilih' , 'PendaftaranController@resumePilihDiagnosa')->name('resume.pilih-diagnosa');
    Route::delete('resume/diagnosa/{id}' , 'PendaftaranController@resumeHapusDiagnosa')->name('resume.hapus-diagnosa');

    // pilih dan hapus pendaftaran resume obat
    Route::post('resume/resep/pilih'    , 'PendaftaranController@resumePilihResep')->name('resume.pilih-resep');
    Route::post('resume/resep/tambah'   , 'PendaftaranController@resumeTambahResep')->name('resume.tambah-resep');
    Route::delete('resume/resep/{id}' , 'PendaftaranController@resumeHapusResep')->name('resume.hapus-resep');

    // pilih dan hapus pendaftaran resume tindakan
    Route::post('resume/tindakan/pilih'     , 'PendaftaranController@resumePilihTindakan')->name('resume.pilih-tindakan');
    Route::delete('resume/tindakan/{id}' , 'PendaftaranController@resumeHapusTindakan')->name('resume.hapus-tindakan');

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
