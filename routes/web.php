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

    // Route antrian
    Route::resource('antrian', 'AntrianController');

    // route master pendaftaran
    Route::get('pendaftaran/{id}/cetak', 'PendaftaranController@cetak')->name('pendaftaran.cetak');
    Route::get('pendaftaran/{id}/selesai', 'PendaftaranController@selesai');
    Route::get('pendaftaran/{id}/input_tanda_vital', 'PendaftaranController@input_tanda_vital')->name('pendaftaran.input_tanda_vital');
    Route::put('pendaftaran/{id}/input_tanda_vital_store', 'PendaftaranController@input_tanda_vital_store')->name('pendaftaran.input_tanda_vital_store');
    Route::get('pendaftaran/{id}/pemeriksaan/{jenis}', 'PendaftaranController@pemeriksaan')->name('pendaftaran.pemeriksaan_tindakan');
    Route::get('pendaftaran/{id}/print', 'PendaftaranController@print')->name('pendaftaran.print');
    Route::get('pendaftaran/create/{pasien_id}', 'PendaftaranController@create');
    Route::resource('pendaftaran', 'PendaftaranController');

    // route pendaftaran riwayat penyakit
    Route::post('riwayat-penyakit-add-item/{id}', 'PendaftaranController@pemeriksaanRiwayatPenyakit');
    Route::get('resume/riwayat_penyakit', 'PendaftaranController@resumeRiwayatPenyakit')->name('resume.riwayatPenyakit');
    Route::delete('riwayat-penyakit-remove-item/{id}', 'PendaftaranController@pemeriksaanRiwayatPenyakitHapus');

    // Pendaftaran Diagnosa Controller's Routes
    Route::post('diagnosa-add-item/{id}', 'PendaftaranDiagnosaController@pemeriksaanDiagnosa');
    Route::get('resume/diagnosaICD', 'PendaftaranDiagnosaController@resumeDiagnosaICD')->name('resume.diagnosaICD');
    Route::delete('diagnosa-remove-item/{id}', 'PendaftaranDiagnosaController@pemeriksaanDiagnosaHapus');

    // Pendaftaran Diagnosa Controller's Routes
    Route::post('rujukan-lab-add-item', 'PendaftaranRujukanLabController@pemeriksaanRujukanLab');
    Route::get('resume/rujukanLaboratorium', 'PendaftaranRujukanLabController@resumeRujukanLab')->name('resume.rujukanLab');
    Route::delete('rujukan-lab-remove-item/{id}', 'PendaftaranRujukanLabController@pemeriksaanRujukanLabHapus');

    // route menampilkan data diagnosa
    Route::get('resume/diagnosa', 'PendaftaranDiagnosaController@resumeDiagnosa')->name('resume.diagnosa');
    // pilih dan hapus pendaftaran resume diagnosa
    Route::post('resume/diagnosa/pilih', 'PendaftaranDiagnosaController@resumePilihDiagnosa')->name('resume.pilih-diagnosa');
    Route::delete('resume/diagnosa/{id}', 'PendaftaranDiagnosaController@resumeHapusDiagnosa')->name('resume.hapus-diagnosa');

    // Pendaftaran Tindakan Controller's Routes 
    Route::get('resume/tindakan', 'PendaftaranTindakanController@resumeTindakan')->name('resume.tindakan');
    // pilih dan hapus pendaftaran resume tindakan
    Route::get('tindakan-add-item', 'PendaftaranTindakanController@resumeTambahTindakan');
    Route::post('resume/tindakan/pilih', 'PendaftaranTindakanController@resumePilihTindakan')->name('resume.pilih-tindakan');
    Route::delete('resume/tindakan/{id}', 'PendaftaranTindakanController@resumeHapusTindakan')->name('resume.hapus-tindakan');

    // PendaftaranResepController
    Route::get('resume/resep', 'PendaftaranResepController@resumeResep')->name('resume.resep');
    Route::post('resume/resep/pilih', 'PendaftaranResepController@resumePilihResep')->name('resume.pilih-resep');
    Route::post('resume/resep/tambah', 'PendaftaranResepController@resumeTambahResep')->name('resume.tambah-resep');
    Route::delete('resume/resep/{id}', 'PendaftaranResepController@resumeHapusResep')->name('resume.hapus-resep');

    // Riwayat Diagnosa
    Route::get('resume/diagnosa', 'DiagnosaController@riwayatDiagnosa');

    // Riwayat Rawat Jalan
    Route::get('resume/rawat-jalan', 'PendaftaranController@riwayatRawatJalan');

    // obat racik ajax routes
    Route::get('resume/obatRacik', 'PendaftaranResepController@dataPemeriksaanResep');
    Route::post('obat-racik-add-item/{id}', 'PendaftaranResepController@storePemeriksaanResep');
    Route::delete('obat-racik-remove-item/{id}', 'PendaftaranResepController@hapusPemeriksaanResep');

    // route pendaftaran pasien yang sudah pernah terdaftar
    Route::post('pendaftaran/insert', 'PendaftaranController@pendaftaranInsert')->name('pendaftaran.insert');

    // purchase order (PO)
    Route::resource('purchase-order-detail', 'PurchaseOrderDetailController');
    Route::resource('purchase-order', 'PurchaseOrderController');
    Route::get('purchase-order/list-barang/{id}', 'PurchaseOrderController@listBarang');
    // purchase order (pimpinan)
    Route::get('purchase-order/approval-detail/{id}', 'PurchaseOrderController@approvalDetail');
    Route::post('purchase-order/approving/{id}', 'PurchaseOrderController@approval')->name('purchase-order.approval');
    // purchase order (gudang)
    Route::get('purchase-order/verifikasi/{id}', 'PurchaseOrderController@verifikasiGudang')->name('purchase-order.verifikasi');
    Route::get('purchase-order/verify/{id}', 'PurchaseOrderController@verifyGudang')->name('purchase-order.verify');

    Route::resource('permintaan-barang-internal', 'PermintaanBarangInternalController');
    Route::get('permintaan-barang-internal/cetak/{id}', 'PermintaanBarangInternalController@cetak')->name('permintaan-barang-internal.cetak');
    Route::get('permintaan-barang-internal/verifikasi/{id}', 'PermintaanBarangInternalController@verifikasi')->name('permintaan-barang-internal.verifikasi');
    Route::post('permintaan-barang-internal/verifikasi/{id}', 'PermintaanBarangInternalController@verify')->name('permintaan-barang-internal.verify');
    Route::resource('permintaan-barang-detail', 'PermintaanBarangInternalDetailController');
    Route::get('purchase-order/{id}/cetak', 'PurchaseOrderController@cetak');
    // Laporan barang excel
    Route::post('barang/export_excel', 'BarangController@export_excel')->name('barang.export_excel');

    // Laporan Fee Tindakan
    Route::get('laporan-fee-tindakan', 'LaporanFeeTindakanController@index');
    Route::get('laporan-fee-tindakan/export_excel', 'LaporanFeeTindakanController@export_excel')->name('laporan-fee-tindakan.export_excel');

    // Tindakan Indikator Pemeriksaan lab
    Route::get('tindakan/{id}/input-indikator', 'TindakanController@input_indikator');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('obat', 'ObatController');
    Route::get('barang/export_excel', 'BarangController@export_excel')->name('barang.export_excel');
    Route::resource('barang', 'BarangController');
    Route::resource('user', 'UserController');
    Route::resource('pasien', 'PasienController');
    Route::resource('diagnosa', 'DiagnosaController');
    Route::resource('poliklinik', 'PoliklinikController');
    Route::resource('gejala', 'GejalaController');
    Route::resource('kategori', 'KategoriController');
    Route::resource('unit-stock', 'UnitStockController');
    Route::resource('satuan', 'SatuanController');
    Route::resource('harilibur', 'HariLiburController');
    Route::resource('tindakan', 'TindakanController');
    Route::resource('indikator-pemeriksaan-lab', 'IndikatorPemeriksaanLabController');
    Route::resource('tindakan-bhp', 'TindakanBHPController');
    Route::resource('akun', 'AkunController');
    Route::resource('jurnal', 'JurnalController');
    Route::resource('komponengaji', 'KomponenGajiController');
    Route::get('gaji/{id}/cetak', 'GajiController@cetak');
    Route::get('gaji/export', 'GajiController@export');
    Route::get('gaji-detail/{id}/edit', 'GajiController@editGajiDetail');
    Route::put('gaji-detail/{id}/update', 'GajiController@update')->name('gaji-detail.update');
    Route::delete('gaji-detail/{id}', 'GajiController@destroy')->name('gaji-detail.delete');
    Route::post('gaji/approve/{id}', 'GajiController@approve');
    Route::resource('gaji', 'GajiController');
    Route::resource('kelompok-pegawai', 'KelompokPegawaiController');
    Route::resource('pbf', 'PBFController');

    Route::resource('perusahaan-asuransi', 'PerusahaanAsuransiController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('icd', 'ICDController');
    Route::resource('shift', 'ShiftController');

    Route::post('stock-opname/export_excel', 'StockOpnameController@export_excel')->name('stock-opname.export_excel');
    Route::resource('stock-opname', 'StockOpnameController');

    Route::resource('kamar', 'KamarController');
    Route::resource('bed', 'BedController');

    Route::prefix('laporan')->group(function () {
        Route::get('/kunjungan-perpoli', 'LaporanController@laporanKunjunganPerPoli');
    });

    Route::get('laporan-tagihan', 'LaporanTagihanController@index');

    /** Route pembayaran */
    Route::get('pembayaran/{id}', 'PembayaranController@index');
    Route::post('pembayaran/store', 'PembayaranController@store')->name('pembayaran.store');
    /** End */

    /**
     * Route neraca saldo
     */
    Route::post('neraca-saldo/export_excel', 'NeracaSaldoController@export_excel')->name('neraca-saldo.export_excel');
    Route::resource('neraca-saldo', 'NeracaSaldoController');
    /** End */

    /**
     * Route pegawai & kelola kehadiran pegawai
     */
    Route::get('pegawai/atur-jadwal', 'PegawaiController@aturJadwal');
    Route::post('pegawai/atur-jadwal', 'PegawaiController@aturJadwalStore')->name('pegawai.atur-jadwal.store');
    Route::resource('pegawai', 'PegawaiController');

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

    /**
     * Kehadiran Pegawai Route
     */
    Route::post('kehadiran-pegawai/export_excel', 'KehadiranPegawaiController@export_excel')->name('kehadiran-pegawai.export_excel');
    Route::post('kehadiran-pegawai/import_excel', 'KehadiranPegawaiController@import_excel')->name('kehadiran-pegawai.import_excel');
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
    Route::get('ajax/select2Dokter', 'AjaxController@select2Dokter');
    Route::get('ajax/select2TindakanLaboratorium', 'AjaxController@select2TindakanLaboratorium');
    Route::get('ajax/select2Poliklinik', 'AjaxController@select2Poliklinik');
    Route::get('ajax/select2Pasien', 'AjaxController@select2Pasien');
    Route::get('ajax/select2Barang', 'AjaxController@select2Barang');
    Route::get('ajax/select2Pendaftaran', 'AjaxController@select2Pendaftaran');
    Route::get('ajax/select2Tindakan', 'AjaxController@select2Tindakan');
    Route::get('ajax/select2ICD', 'AjaxController@select2ICD');
    Route::get('ajax/select2User', 'AjaxController@select2User');
    Route::get('ajax/select2Perusahaan', 'AjaxController@select2Perusahaan');
    Route::get('ajax/pasien', 'AjaxController@pasien');
    Route::get('ajax/user', 'AjaxController@user');
    Route::post('ajax/purchase-order-edittable', 'AjaxController@purchaseOrderEditTable');
    Route::post('ajax/permintaan-barang-detail-editable', 'AjaxController@permintaanBarangDetailEditable');
    Route::post('ajax/indikator-editable', 'AjaxController@indikatorEditable');
    Route::get('ajax/approval-item-purchase-order', 'AjaxController@approvalItemPurchaseOrder');
    Route::get('/ajax/dropdown-dokter', 'AjaxController@dropdownDokter');
});
