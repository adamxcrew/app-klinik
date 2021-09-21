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
    Route::get('pendaftaran/{id}/cetak', 'PendaftaranController@cetak')->name('pendaftaran.cetak');
    Route::get('pendaftaran/{id}/input_tanda_vital', 'PendaftaranController@input_tanda_vital')->name('pendaftaran.input_tanda_vital');
    Route::put('pendaftaran/{id}/input_tanda_vital_store', 'PendaftaranController@input_tanda_vital_store')->name('pendaftaran.input_tanda_vital_store');
    Route::get('pendaftaran/{id}/print', 'PendaftaranController@print')->name('pendaftaran.print');
    Route::resource('pendaftaran', 'PendaftaranController');

    // route pendaftaran pasien yang sudah pernah terdaftar
    Route::post('pendaftaran/insert', 'PendaftaranController@pendaftaranInsert')->name('pendaftaran.insert');

    // route menampilkan data diagnosa, resep dan tindakan yang dipilih
    Route::get('resume/diagnosa', 'PendaftaranController@resumeDiagnosa')->name('resume.diagnosa');
    Route::get('resume/resep', 'PendaftaranController@resumeResep')->name('resume.resep');
    Route::get('resume/tindakan', 'PendaftaranController@resumeTindakan')->name('resume.tindakan');

    // pilih dan hapus pendaftaran resume diagnosa
    Route::post('resume/diagnosa/pilih', 'PendaftaranController@resumePilihDiagnosa')->name('resume.pilih-diagnosa');
    Route::delete('resume/diagnosa/{id}', 'PendaftaranController@resumeHapusDiagnosa')->name('resume.hapus-diagnosa');

    // pilih dan hapus pendaftaran resume obat
    Route::post('resume/resep/pilih', 'PendaftaranController@resumePilihResep')->name('resume.pilih-resep');
    Route::post('resume/resep/tambah', 'PendaftaranController@resumeTambahResep')->name('resume.tambah-resep');
    Route::delete('resume/resep/{id}', 'PendaftaranController@resumeHapusResep')->name('resume.hapus-resep');

    // pilih dan hapus pendaftaran resume tindakan
    Route::post('resume/tindakan/pilih', 'PendaftaranController@resumePilihTindakan')->name('resume.pilih-tindakan');
    Route::delete('resume/tindakan/{id}', 'PendaftaranController@resumeHapusTindakan')->name('resume.hapus-tindakan');

    // Laporan barang excel
    Route::post('barang/export_excel', 'BarangController@export_excel')->name('barang.export_excel');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('obat', 'ObatController');
    Route::resource('barang', 'BarangController');
    Route::resource('user', 'UserController');
    Route::resource('pasien', 'PasienController');
    Route::resource('diagnosa', 'DiagnosaController');
    Route::resource('poliklinik', 'PoliklinikController');
    Route::resource('gejala', 'GejalaController');
    Route::resource('kategori', 'KategoriController');
    Route::resource('satuan', 'SatuanController');
    Route::resource('harilibur', 'HariLiburController');
    Route::resource('tindakan', 'TindakanController');
    Route::resource('akun', 'AkunController');
    Route::resource('jurnal', 'JurnalController');
    Route::resource('komponengaji', 'KomponenGajiController');
    Route::resource('gaji', 'GajiController');
    Route::resource('pegawai', 'PegawaiController');
    Route::resource('asuransi', 'AsuransiController');
    Route::resource('icd', 'ICDController');

    Route::resource('stock-opname', 'StockOpnameController');

    Route::resource('kamar', 'KamarController');
    Route::resource('bed', 'BedController');


    Route::prefix('laporan')->group(function () {
        Route::get('/kunjungan-perpoli', 'LaporanController@laporanKunjunganPerPoli');
    });

    /**
     * Jadwal Praktek Dokter
     */
    Route::get('jadwal-praktek', 'JadwalPraktekController@index');
    Route::resource('jadwal-praktek', 'JadwalPraktekController');

    /**
     * Tunjangan Gaji Pegawai
     */
    Route::get('tunjangan-gaji', 'TunjanganGajiController@index');
    Route::resource('tunjangan-gaji', 'TunjanganGajiController');

    /**
     * Surat Sehat Sakit Route
     */
    Route::get('surat-sehat-sakit/{tipe}', 'SuratSehatSakitController@create');
    Route::resource('surat-sehat-sakit', 'SuratSehatSakitController');
    Route::post('surat-sehat/store_sehat', 'SuratSehatSakitController@store_surat_sehat')->name('surat-sehat.store_sehat');
    Route::post('surat-sehat/store_sakit', 'SuratSehatSakitController@store_surat_sakit')->name('surat-sakit.store_sakit');
    Route::get('surat-sehat-sakit/{id}/print', 'SuratSehatSakitController@print')->name('surat.print');

    /** End */

    Route::post('kehadiran-pegawai/export_excel', 'KehadiranPegawaiController@export_excel')->name('kehadiran-pegawai.export_excel');
    Route::resource('kehadiran-pegawai', 'KehadiranPegawaiController');
    Route::get('buku-besar', 'BukuBesarController@index');
    Route::get('buku-besar/periode/{kode}', 'BukuBesarController@show_periode');
    Route::get('buku-besar/{kode}', 'BukuBesarController@show');
    Route::get('profile', 'UserController@profile');
    Route::put('profile', 'UserController@profileUpdate')->name('user.profile');
    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::put('setting', 'SettingController@update')->name('setting.update');
    Route::get('ajax/dropdown-dokter-berdasarkan-poliklinik', 'AjaxController@dropdownDokterBerdasarkanPoliklinik');
    Route::get('ajax/select2Desa', 'AjaxController@select2Desa');
    Route::get('ajax/select2Pasien', 'AjaxController@select2Pasien');
});
