<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// method yang akan mengalihkan/exception jika user
// mengakses url yang tidak terdaftar di routing
App::missing(function ($exception) {
    return Response::view('error', compact($exception), 404);
});

Route::get('dashboard', function () {
    return View::make('pages.dashboard');
})->before('auth');

Route::get('date', function () {

    $date = new DateTime('now');
    $date->modify('last day of this month');
    echo $date->format('Y-m-d');
})->before('auth');

Route::get('landing-page', function () {
    return View::make('landing.landing');
})->before('auth');

Route::get('/', function () {
    // menampilkan halaman utama, berisi dokumentasi dari program simdes
    return View::make('pages.login');
})->before('guest');

#Namespace User
Route::group(['namespace' => 'User'], function () {
    // auth login menampilkan halaman login
    // before guest berarti jika Auth sudah dicek maka akan diredirect ke dashboard
    Route::get('login', ['before' => 'guest', 'as' => 'auth.login', 'uses' => 'UserController@index']);

    #post login
    Route::post('login', 'UserController@postLogin');

    // auth logout method logout untuk menghapus session
    // before auth berarti hanya bisa diakses oleh user yang sudah login
    Route::get('logout', ['before' => 'auth', 'as' => 'auth.logout', 'uses' => 'UserController@getLogout']);

    // menampilkan halaman registrasi
    Route::get('registration', ['before' => 'guest', 'as' => 'auth.registration', 'uses' => 'UserRegistrationController@index']);
    // post data registrasi
    Route::post('data-registration', 'UserRegistrationController@registration');

});

#Namespace User
// digunakan untuk create user baru, diakses oleh administrator
Route::group(['namespace' => 'User', 'before' => ['auth', 'auth.post', 'admin']], function () {

    Route::resource('data-user', 'UserCreateController');
    Route::post('data-user/read', ['as' => 'data-user.read', 'uses' => 'UserCreateController@read']);
});

#Namespace User
// digunakan untuk create user baru, diakses oleh administrator
Route::group(['namespace' => 'User'], function () {
    // untuk reset password
    Route::post('reset-password', ['as' => 'reset.password', 'uses' => 'UserCreateController@resetPassword']);

    // untuk konfirmasi akun / aktifasi akun
    Route::get('akun-activation/{email}/{activation_code}', ['as' => 'akun.activation', 'uses' => 'UserCreateController@konfirmasiAkun']);

    Route::get('get-reset-password/{email}/{remember_token}', ['as' => 'reset.password.form', 'uses' => 'UserCreateController@konfirmResetPassword']);
    Route::post('post-reset-password', ['as' => 'post.reset.password', 'uses' => 'UserCreateController@postResetPassword']);
});


// Namespace Profile
Route::group(['before' => 'auth', 'namespace' => 'Profile'], function () {
    // menampilkan halaman profile tanpa menggunakan slug
    Route::get('profile', ['before' => 'auth', 'as' => 'profile', 'uses' => 'ProfileController@index']);

    // post update profile
    Route::get('profile-update', ['before' => 'auth', 'as' => 'profile.index', 'uses' => 'ProfileController@index']);
    Route::post('profile-update', ['before' => 'auth', 'as' => 'profile.update', 'uses' => 'ProfileController@update']);

    // menampilkan halaman ganti password
    Route::get('profile/ganti-password', ['before' => 'auth', 'as' => 'ganti.password', 'uses' => 'ProfileController@passwordIndex']);
    Route::post('profile/post-ganti-password', ['before' => 'auth', 'as' => 'post.ganti.password', 'uses' => 'ProfileController@postGantiPassword']);
});


# Namespace Akun
// before filter back office = ini hanya bisa diakses oleh administrator
// dengan is_admin = 100 yang artinya dia adalah pengelola sistem
Route::group(['before' => ['auth', 'backoffice'], 'namespace' => 'Akun'], function () {
# Akun
    Route::resource('data-akun', 'AkunController');
    Route::post('data-akun/read', ['as' => 'data-akun.read', 'uses' => 'AkunController@read']);
# Kelompok
    Route::resource('data-kelompok', 'KelompokController');
    Route::post('data-kelompok/read', ['as' => 'data-kelompok.read', 'uses' => 'KelompokController@read']);
# Jenis
    Route::resource('data-jenis', 'JenisController');
    Route::post('data-jenis/read', ['as' => 'data-jenis.read', 'uses' => 'JenisController@read']);
});

# Namespace Akun
// before filter back office = ini hanya bisa diakses oleh administrator
// dengan is_admin = 100 yang artinya dia adalah pengelola sistem
// ini juga bisa diakses oleh administrator dengan is_admin  = 1
Route::group(['before' => ['auth', 'backoffice.admin'], 'namespace' => 'Akun'], function () {
# Obyek
    Route::resource('data-obyek', 'ObyekController');
    Route::post('data-obyek/read', ['as' => 'data-obyek.read', 'uses' => 'ObyekController@read']);
# Rincian Obyek
    Route::resource('data-rincian-obyek', 'RincianObyekController');
    Route::post('data-rincian-obyek/read', ['as' => 'data-rincian-obyek.read', 'uses' => 'RincianObyekController@read']);
});

# Namespace Pejabat
Route::group(['namespace' => 'Pejabat', 'before' => ['auth', 'admin']], function () {
    Route::resource('tim-anggaran', 'PejabatDesaController');
    Route::post('tim-anggaran/read', ['as' => 'pejabat-desa.read', 'uses' => 'PejabatDesaController@read']);
});

# Namespace Pengaturan
Route::group(['namespace' => 'Organisasi', 'before' => ['auth', 'backoffice.admin']], function () {
    Route::resource('organisasi', 'OrganisasiController', ['only' => ['index', 'show', 'update', 'edit']]);
});

# Namespace MasterData
Route::group(['namespace' => 'MasterData', 'before' => ['auth', 'backoffice']], function () {
    #master provinsi
    Route::resource('master-provinsi', 'ProvinsiController');
    Route::post('master-provinsi/read', ['as' => 'master-provinsi.read', 'uses' => 'ProvinsiController@read']);
    #master kabupaten
    Route::resource('master-kabupaten', 'KabupatenController');
    Route::post('master-kabupaten/read', ['as' => 'master-kabupaten.read', 'uses' => 'KabupatenController@read']);
});


# Namespace RKPDesa
Route::group(['namespace' => 'RKPDesa', 'before' => ['auth', 'rkpdesa']], function () {
# data RKPDesa
    Route::resource('data-rkpdesa', 'RKPDesaController');
    Route::post('data-rkpdesa/read', ['as' => 'rkpdesa.read', 'uses' => 'RKPDesaController@read']);
# Indikator Masukan
    Route::resource('data-indikator-masukan', 'IndikatorMasukanController');
# Indikator Keluaran
    Route::resource('data-indikator-keluaran', 'IndikatorKeluaranController');
# Indikator hasil
    Route::resource('data-indikator-hasil', 'IndikatorHasilController');
# Indikator Manfaat
    Route::resource('data-indikator-manfaat', 'IndikatorManfaatController');
#cetak
    Route::get('cetak-rkpdesa-formulir-1', ['as' => 'cetak-rkpdesa-formulir-1.cetak', 'uses' => 'CetakRKPDesa@cetakFormulir1']);
    Route::get('cetak-rkpdesa-formulir-2', ['as' => 'cetak-rkpdesa-formulir-2.cetak', 'uses' => 'CetakRKPDesa@cetakFormulir2']);
    Route::get('cetak-rkpdesa-formulir-3', ['as' => 'cetak-rkpdesa-formulir-3.cetak', 'uses' => 'CetakRKPDesa@cetakFormulir3']);
    Route::get('cetak-rkpdesa-formulir-4', ['as' => 'cetak-rkpdesa-formulir-4.cetak', 'uses' => 'CetakRKPDesa@cetakFormulir4']);
});

# User Log
// todo user log akan dihapus dan digantikan dengan event listener
Route::resource('user-log', 'UserManagemenController');
#menampilkan aktifitas user
// nanti akan masuk ke namespace profile
Route::post('user-log/read', ['as' => 'user-log.read', 'uses' => 'UserManagemenController@read']);
Route::post('user-profile/{id}', ['as' => 'user-profile.update', 'uses' => 'UserManagemenController@update']);
// user profile advanced
Route::get('user-profile/{slug}', ['as' => 'user-profile.show', 'uses' => 'Pejabat\\PejabatDesaController@findBySlug']);

# Namespace ssh
Route::group(['namespace' => 'SSH', 'before' => ['auth', 'backoffice']], function () {
# kelas barang
    Route::resource('data-kelas-barang', 'KelasBarangController');
    Route::post('data-kelas-barang/read', 'KelasBarangController@read');
# kelompok barang
    Route::resource('data-kelompok-barang', 'KelompokBarangController');
    Route::post('data-kelompok-barang/read', 'KelompokBarangController@read');
# jenis barang
    Route::resource('data-jenis-barang', 'JenisBarangController');
    Route::post('data-jenis-barang/read', 'JenisBarangController@read');
# obyek barang
    Route::resource('data-obyek-barang', 'ObyekBarangController');
    Route::post('data-obyek-barang/read', 'ObyekBarangController@read');
# rincian barang
    Route::resource('data-rincian-obyek-barang', 'RincianObyekBarangController');
    Route::post('data-rincian-obyek-barang/read', 'RincianObyekBarangController@read');
});

Route::group(['namespace' => 'RPJMDesa', 'before' => ['auth', 'rpjmdesa']], function () {
# Visi
    Route::resource('data-rpjmdesa', 'RPJMDesaController');
    Route::post('data-rpjmdesa/read', 'RPJMDesaController@read');
# misi
    Route::resource('data-misi', 'MisiController');
    Route::post('data-misi/read', ['as' => 'data-misi.read', 'uses' => 'MisiController@read']);
# masalah
    Route::resource('data-masalah', 'MasalahController');
    Route::post('data-masalah/read', ['as' => 'data-masalah.read', 'uses' => 'MasalahController@read']);
    Route::get('detil-masalah/{id}', ['as' => 'detil-masalah.show', 'uses' => 'MasalahController@detil']);
# masalah -> potensi
    Route::resource('data-potensi', 'PotensiController');
    Route::post('data-potensi/read', ['as' => 'data-potensi.read', 'uses' => 'PotensiController@read']);
# masalah -> pemetaan
    Route::resource('data-pemetaan', 'PemetaanController');
    Route::post('data-pemetaan/read', ['as' => 'data-pemetaan.read', 'uses' => 'PemetaanController@read']);
# masalah -> prgoram
    Route::resource('data-program', 'ProgramController');
    Route::post('data-program/read', ['as' => 'data-program.read', 'uses' => 'ProgramController@read']);
# cetak dokumen
    Route::get('cetak-rpjmdesa-formulir-1', ['as' => 'cetak-rpjmdesa-formulir-1.cetak', 'uses' => 'ProgramController@cetakFormulir1']);
    Route::get('cetak-rpjmdesa-formulir-2', ['as' => 'cetak-rpjmdesa-formulir-2.cetak', 'uses' => 'ProgramController@cetakFormulir2']);
    Route::get('cetak-rpjmdesa-formulir-3', ['as' => 'cetak-rpjmdesa-formulir-3.cetak', 'uses' => 'ProgramController@cetakFormulir3']);
    Route::get('cetak-rpjmdesa-formulir-4', ['as' => 'cetak-rpjmdesa-formulir-4.cetak', 'uses' => 'ProgramController@cetakFormulir4']);
    Route::get('cetak-rpjmdesa-formulir-5', ['as' => 'cetak-rpjmdesa-formulir-5.cetak', 'uses' => 'MasalahController@cetakFormulir5']);
    Route::get('cetak-rpjmdesa-formulir-6', ['as' => 'cetak-rpjmdesa-formulir-6.cetak', 'uses' => 'ProgramController@cetakFormulir6']);
});

#Transaksi
// untuk before auth menggunakan langsung fungsi
// dari user sendiri misal fungsi bendahara
Route::group(['namespace' => 'Transaksi', 'before' => ['auth', 'bendahara']], function () {
    #pendapatan
    Route::resource('data-tr-pendapatan', 'TransaksiPendapatanController');
    Route::post('data-tr-pendapatan/read', 'TransaksiPendapatanController@read');

    // menampilkan halaman laporan
    Route::get('laporan-pendapatan', 'LaporanPendapatanController@index');
    Route::post('laporan-pendapatan', 'LaporanPendapatanController@laporan');

    // menampilkan halaman bukti transaksi pendapatan untuk BKU(Buku kas Umum)
    Route::get('laporan-bku-pendapatan', 'LaporanBkuPendapatanController@index');
    Route::post('laporan-bku-pendapatan/read', 'LaporanBkuPendapatanController@read');
    Route::get('cetak-bku', 'LaporanBkuPendapatanController@cetakBKU');

    // posting pendapatan
    Route::post('pendapatan-posting', 'TransaksiPendapatanController@posting');
#belanja
    Route::resource('data-tr-belanja', 'BelanjaController');
    Route::post('data-tr-belanja/read', 'BelanjaController@read');

    // posting belanja
    Route::post('belanja-posting', 'BelanjaController@posting');

    // menampilkan halaman bukti transaksi belanja untuk BKU(Buku kas Umum)
    Route::get('laporan-bku-belanja', 'LaporanBkuBelanjaController@index');
    Route::post('laporan-bku-belanja/read', 'LaporanBkuBelanjaController@read');
    Route::get('cetak-bku-belanja', 'LaporanBkuBelanjaController@cetakBKU');

#pembiayaan
    Route::resource('data-tr-pembiayaan', 'TransaksiPembiayaanController');
    Route::post('data-tr-pendapatan/read', 'TransaksiPendapatanController@read');
});

# ini masih memakai versi lama
//    @todo : nanti akan dievaluasi dan diubah lagi
Route::get('ajax-akun', ['as' => 'akun.ajax', 'uses' => 'KelompokController@ajax']);
Route::get('ajax-kelompok', ['as' => 'kelompok.ajax', 'uses' => 'jenisController@ajax']);
Route::get('ajax-jenis', ['as' => 'jenis.ajax', 'uses' => 'ObyekController@ajax']);
Route::get('ajax-obyek', ['as' => 'rincian.ajax', 'uses' => 'RincianObyekController@ajax']);
Route::get('ajax-kewenangan', ['as' => 'kewenangan.ajax', 'uses' => 'BidangController@ajax']);
Route::get('ajax-bidang', ['as' => 'bidang.ajax', 'uses' => 'ProgramController@ajax']);
Route::get('ajax-program', ['as' => 'program.ajax', 'uses' => 'KegiatanController@ajax']);
Route::post('ajax-kegiatan/{program}', ['as' => 'kegiatan.ajax', 'uses' => 'KegiatanController@ajaxKegiatan']);
Route::get('ajax-sumber-dana', ['as' => 'sumber.ajax', 'uses' => 'AjaxController@sumberDana']);
Route::get('ajax-rpjmdesa', ['as' => 'sumber.ajax', 'uses' => 'RpjmdesaController@ajax']);
Route::get('ajax-prov', ['as' => 'prov.ajax', 'uses' => 'AjaxController@ajaxProv']);

Route::post('ajax-kab/{kode_prov}', ['as' => 'kab.ajax', 'uses' => 'AjaxController@ajaxKab']);
Route::post('ajax-kec/{kode_kab}', ['as' => 'kec.ajax', 'uses' => 'AjaxController@ajaxKec']);
Route::post('ajax-desa/{kode_kec}', ['as' => 'desa.ajax', 'uses' => 'AjaxController@ajaxDesa']);

# Namesapce Ajax
Route::group(['namespace' => 'Ajax', 'before' => 'auth'], function () {
#APBDesa
    Route::get('ajax-data-akun', ['as' => 'ajax.data.akun', 'uses' => 'AjaxController@getAkun']);
    Route::post('ajax-data-kelompok', ['as' => 'ajax.data.kelompok', 'uses' => 'AjaxController@getKelompok']);
    Route::post('ajax-data-jenis', ['as' => 'ajax.data.jenis', 'uses' => 'AjaxController@getJenis']);
    Route::post('ajax-data-obyek', ['as' => 'ajax.data.obyek', 'uses' => 'AjaxController@getObyek']);
    Route::post('ajax-data-rincian-obyek', ['as' => 'ajax.data.rincian-obyek', 'uses' => 'AjaxController@getRincianObyek']);
    #pejabat desa
    Route::get('ajax-pejabat-desa', ['as' => 'pejabat-desa.ajax', 'uses' => 'AjaxPejabatController@getPejabatDesa']);
    #Kewenangan
    Route::get('ajax-list-kewenangan', ['as' => 'ajax.list.kewenangan', 'uses' => 'AjaxController@getListKewenangan']);
    #fungsi
    Route::get('ajax-list-fungsi', ['as' => 'ajax.list.fungsi', 'uses' => 'AjaxController@getListFungsi']);
    Route::post('ajax-list-bidang', ['as' => 'ajax.list.bidang', 'uses' => 'AjaxController@getListBidang']);
    Route::post('ajax-list-program-kewenangan', ['as' => 'ajax.list.program.kewenangan', 'uses' => 'AjaxController@getListProgram']);
    #diakses oleh RPJMDesa
    Route::get('ajax-list-program', ['as' => 'ajax.list.program', 'uses' => 'AjaxController@listProgram']);
    Route::get('ajax-list-program-rpjmdesa', ['as' => 'ajax.list.program', 'uses' => 'AjaxController@listProgramRPJMDesa']);
    Route::post('ajax-list-kegiatan', ['as' => 'ajax.list.kegiatan', 'uses' => 'AjaxController@getListKegiatan']);

    Route::get('ajax-list-kelompok', ['as' => 'ajax.list.kelompok', 'uses' => 'AjaxController@getListkelompok']);
    Route::get('ajax-list-jenis', ['as' => 'ajax.list.jenis', 'uses' => 'AjaxController@getListJenis']);
    Route::get('ajax-list-obyek', ['as' => 'ajax.list.obyek', 'uses' => 'AjaxController@getListObyek']);
    Route::get('ajax-list-kegiatan', ['as' => 'ajax.list.kegiatan', 'uses' => 'AjaxController@getListKegiatanRKPDesa']);
    #pendapatan
    Route::get('ajax-count-pendapatan', ['as' => 'ajax.list.count.pendapatan', 'uses' => 'AjaxController@getCountPendapatan']);
    Route::get('ajax-pendapatan', ['as' => 'ajax.list.pendapatan', 'uses' => 'AjaxPendapatan@getPendapatan']);
#ssh
    Route::get('ajax-list-kelas-barang', ['as' => 'ajax.list.kelas.barang', 'uses' => 'AjaxSSHController@getListKelasBarang']);
    Route::post('ajax-list-kelompok-barang', ['as' => 'ajax.list.kelompok.barang', 'uses' => 'AjaxSSHController@getListKelompokBarang']);
    Route::post('ajax-list-jenis-barang', ['as' => 'ajax.list.jenis.barang', 'uses' => 'AjaxSSHController@getListJenisBarang']);
    Route::post('ajax-list-obyek-barang', ['as' => 'ajax.list.obyek.barang', 'uses' => 'AjaxSSHController@getListObyekBarang']);
#autocomplete
    Route::get('autocomplete-belanja', ['as' => 'autocomplete-belanja', 'uses' => 'AjaxPendapatan@getBelanja']);
    Route::get('autocomplete-ssh', ['as' => 'autocomplete.ssh', 'uses' => 'AjaxSSHController@autocomplete']);
});

# Namespace Pendapatan
Route::group(['namespace' => 'Pendapatan', 'before' => ['auth', 'bendahara']], function () {
    Route::resource('data-pendapatan', 'PendapatanController');
    Route::post('data-pendapatan/read', 'PendapatanController@read');
    Route::post('data-histori-pendapatan/{id}', 'PendapatanController@setHistory');
    Route::post('pendapatan-set-rka', 'PendapatanController@setRKA');
    Route::post('pendapatan-set-dpa', 'PendapatanController@setDPA');
});

# Namespace Belanja
Route::group(['namespace' => 'Belanja', 'before' => ['auth', 'bendahara']], function () {
    Route::post('belanja-set-rka', 'BelanjaController@setRKA');
    Route::post('belanja-set-dpa', 'BelanjaController@setDPA');
    Route::resource('data-belanja', 'BelanjaController');
    Route::post('data-belanja/read', 'BelanjaController@read');
    Route::post('data-histori-belanja/{id}', 'BelanjaController@setHistory');
});

# Namespace Pembiayaan
Route::group(['namespace' => 'Pembiayaan', 'before' => ['auth', 'bendahara']], function () {
    Route::resource('data-pembiayaan', 'PembiayaanController');
    Route::post('data-pembiayaan/read', 'PembiayaanController@read');
    Route::post('pembiayaan-set-rka', 'PembiayaanController@setRKA');
    Route::post('pembiayaan-set-dpa', 'PembiayaanController@setDPA');
});

# Namespace rka
Route::group(['namespace' => 'RKA', 'before' => ['auth', 'rka']], function () {
    Route::get('data-rka-desa', 'RKAController@index');
    Route::get('rka-cover', 'RKAController@cover');
    Route::get('rka-formulir-1', 'RKAController@formulir1');
    Route::get('rka-formulir-2', 'RKAController@formulir2');
    Route::get('rka-formulir-3', 'RKAController@formulir3');
    Route::get('rka-formulir-4', 'RKAController@formulir4');
#set dpa
    Route::get('data-rka-desa/{id}/{cmd}', 'RKAController@setDPA');
#unset rka
    Route::get('unset-rka/{id}/{cmd}', 'RKAController@unsetRKA');
#unset dpa
    Route::get('unset-dpa/{id}/{cmd}', 'RKAController@unsetDPA');
#set dpa
    Route::get('data-rka-desa/{id}/{cmd}', 'RKAController@setDPA');
});

# Namespace dpa
Route::group(['namespace' => 'DPA', 'before' => ['auth', 'dpa']], function () {
    Route::get('data-dpa-desa', 'DPAController@index');
    Route::get('dpa-cover', 'DPAController@cover');
    Route::get('dpa-formulir-1', 'DPAController@formulir1');
    Route::get('dpa-formulir-2', 'DPAController@formulir2');
    Route::get('dpa-formulir-3', 'DPAController@formulir3');
    Route::get('dpa-formulir-4', 'DPAController@formulir4');
});

# Namespace Perdes
Route::group(['before' => ['auth', 'auth.post', 'perdes'], 'namespace' => 'Perdes'], function () {
##Perdes RPJMDesa
    #Judul
    Route::resource('data-perdes-judul', 'JudulController');
    Route::post('data-perdes-judul/read', ['as' => 'data.perdes.judul.read', 'uses' => 'JudulController@read']);
    #Konsideran
    Route::resource('data-perdes-konsideran', 'KonsideranController');
    Route::post('data-perdes-konsideran/read', ['as' => 'data.perdes.konsideran.read', 'uses' => 'KonsideranController@read']);
    #Dasar Hukum
    Route::resource('data-perdes-dasar-hukum', 'DasarHukumController');
    Route::post('data-perdes-dasar-hukum/read', ['as' => 'data.perdes.dasar.hukum.read', 'uses' => 'DasarHukumController@read']);
    #Batang Tubuh
    Route::resource('data-perdes-batang-tubuh', 'BatangTubuhController');
    Route::post('data-perdes-batang-tubuh/read', ['as' => 'data.perdes.batang.tubuh.read', 'uses' => 'BatangTubuhController@read']);
    #Penutup
    Route::resource('data-perdes-penutup', 'PenutupController');
    Route::post('data-perdes-penutup/read', ['as' => 'data.perdes.penutup.read', 'uses' => 'PenutupController@read']);
    #Ketentuan
    Route::resource('data-perdes-ketentuan-umum', 'KetentuanController');
    Route::post('data-perdes-ketentuan-umum/read', ['as' => 'data.perdes.ketentuan.read', 'uses' => 'KetentuanController@read']);
    #Materi Pokok
    Route::resource('data-perdes-materi-pokok', 'MateriPokokController');
    Route::post('data-perdes-materi-pokok/read', ['as' => 'data.perdes.materi.pokok.read', 'uses' => 'MateriPokokController@read']);

    Route::resource('data-perdes-materi-pokok-poin', 'MateriPokokPoinController');
    Route::post('data-perdes-materi-pokok-poin/read', ['as' => 'data.perdes.materi.pokok.poin.read', 'uses' => 'MateriPokokPoinController@read']);

    #Ketentuan Penutup
    Route::resource('data-perdes-ketentuan-penutup', 'KetentuanPenutupController');
    Route::post('data-perdes-ketentuan-penutup/read', ['as' => 'data.perdes.ketentuan.penutup.read', 'uses' => 'KetentuanPenutupController@read']);

##Perdes APBDesa
    #Judul
    Route::resource('data-perdes-apbdesa', 'JudulController');

    #Ajax
    Route::get('ajax-perdes-judul', ['as' => 'perdes.judul', 'uses' => 'AjaxPerdes@getJudul']);
    #Cetak
    Route::get('cetak-perdes-rpjmdesa/{id}', ['as' => 'cetak.perdes.rpjmdesa', 'uses' => 'JudulController@cetakRPJMDesa']);
    Route::get('cetak-perdes-apbdesa/{id}', ['as' => 'cetak.perdes.apbdesa', 'uses' => 'JudulController@cetakAPBDesa']);
});

# Namespace Kewenangan diakses oleh backoffice
Route::group(['before' => ['auth', 'backoffice'], 'namespace' => 'Kewenangan'], function () {
    #Kewenangan
    Route::resource('data-kewenangan', 'KewenanganController');
    Route::post('data-kewenangan/read', ['as' => 'data.kewenangan.read', 'uses' => 'KewenanganController@read']);

    #fungsi
    Route::resource('data-fungsi-kewenangan', 'FungsiController');
    Route::post('data-fungsi-kewenangan/read', ['as' => 'data.fungsi.read', 'uses' => 'FungsiController@read']);

    #bidang
    Route::resource('data-bidang-kewenangan', 'BidangController');
    Route::post('data-bidang-kewenangan/read', ['as' => 'data.bidang.read', 'uses' => 'BidangController@read']);
});

# Namespace Kewenangan diakses oleh backoffice , admin dan kepala desa
Route::group(['before' => ['auth', 'backoffice.admin'], 'namespace' => 'Kewenangan'], function () {
    #program
    Route::resource('data-program-kewenangan', 'ProgramController');
    Route::post('data-program-kewenangan/read', ['as' => 'data.program.read', 'uses' => 'ProgramController@read']);
    #kegiatan
    Route::resource('data-kegiatan-kewenangan', 'KegiatanController');
    Route::post('data-kegiatan-kewenangan/read', ['as' => 'data.kegiatan.read', 'uses' => 'KegiatanController@read']);


});
Route::group(['before' => ['auth', 'perangkat'], 'namespace' => 'SSH'], function () {
    Route::resource('standar-satuan-harga-barang', 'SshBarangController', ['only' => ['index']]);

    Route::post('standar-satuan-harga-barang/read', ['as' => 'ssh.barang', 'uses' => 'SshBarangController@read']);
});

# Namespace BackOffice
Route::group(['namespace' => 'BackOffice', 'before' => ['auth', 'backoffice']], function () {
// Menu yang hanya bisa diakses oleh backoffice, fitur yang dimiliki bisa untuk
// aktifkan/nonaktifkan oraganisasi atau user, memantau setiap transaksi yang
// dilakukan oleh user, sebagai IT/Sistim support sistem/pnegelola sistem

    // menampilkan list organisasi
    Route::get('backoffice/data-list-organisasi', 'OrganisasiListController@index');
    Route::post('backoffice/data-list-organisasi/read', 'OrganisasiListController@read');

    // menampilkan list user
    Route::get('backoffice/data-list-user', 'UserListController@index');
    Route::post('backoffice/data-list-user/read', 'UserListController@read');
    Route::post('backoffice/set-demo-user', 'UserListController@setDemo');
    Route::post('backoffice/unset-demo-user', 'UserListController@unsetDemo');
    Route::post('backoffice/set-active-user', 'UserListController@setActive');
    Route::post('backoffice/unset-active-user', 'UserListController@unsetActive');
});

Route::get('xls-importer', function () {
    return $exel = Excel::load('xls/data.xlsx')->toArray();

})->before('auth');

Route::get('upload/create', function () {
    return View::make('upload');
})->before('auth');

// usage inside a laravel route
Route::post('/upload/image', function () {

    $name_random = str_random(60);
    $temp_path = '/storage/upload/avatar/';
    $destinationPath = 'upload/avatar/';
    $img_temp = Input::file('image')->move(__DIR__ . $temp_path . $name_random . '.jpg');

    Image::make($img_temp)->save('upload/avatar/' . $name_random . '.jpg');

    return Response::json(['success' => true, 'file' => asset($destinationPath . $name_random . '.jpg')]);
});