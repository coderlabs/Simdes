<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request) {
    //
});


App::after(function ($request, $response) {
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function () {
    if (!Auth::check()) {
        // cek apakah data dikirim dengan ajax
        // kembali response untuk diproses
        // redirect login via javascript
        if (Request::ajax()) {
            return [
                'Status' => 'Warning',
                'Action' => 'Logout',
                'msg'    => 'Session anda telah habis, silahkan login kembali.',
            ];
        }
        return Redirect::route('auth.login')->with([
            'message' => 'Session anda telah habis, silahkan login kembali.'
        ]);
    } elseif (Auth::user()->is_demo != 0) {
        // is_demo 0 berarti akun aktif dan tidak demo
        Auth::logout();
        return Redirect::route('auth.login')->with([
            'message' => 'Akun yang anda miliki hanya untuk pelatihan, hubungi <a href="mailto:info@simdes-bbpmd.com" target="_blank">info@simdes-bbpmd.com</a>'
        ]);
    } elseif (Auth::user()->is_active != 2) {
        // is_active 2 berarti akun aktif
        Auth::logout();
        return Redirect::route('auth.login')->with([
            'message' => 'Akun anda belum diaktifkan, periksa email anda untuk melakukan aktivasi.'
        ]);
    }
});

Route::filter('guest', function () {
    if (Auth::check()) {
        return Redirect::to('dashboard');
    }
});

// Route::filter('guest', function()
// {
// 	if (Auth::guest()) return Redirect::route('auth.login');
// });


// Route::filter('auth.basic', function()
// {
// 	return Auth::basic();
// });

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) return Redirect::route('auth.login');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if (Session::token() != Input::get('_token')) {
        Auth::logout();
        return [
            'Status' => 'Warning',
            'Action' => 'Logout',
            'msg'    => 'Data dikirim tidak sesuai dengan prosedur program. Silahkan ulangi lagi langkah terakhir anda!',
        ];
    }
});


/*
|--------------------------------------------------------------------------
| Session Expired Exceptions
|--------------------------------------------------------------------------
|
| Jika session telah habis maka akan muncul pemeberitahun di alert notify
| yang memberitahu bahwa session telah habis dan halaman otomatis akan
| dialihkan ke halaman login ini berlaku untuk setiap method post.
|
*/

Route::filter('auth.post', function () {
    if (Auth::guest()) {
        return Response::json([
            'Status' => 'Logout',
            'msg'    => 'Session anda telah habis/anda sudah log out. Silahkan Login Kembali'
        ]);
    }
});


/*
|--------------------------------------------------------------------------
| Pembagian Hak Akses
|--------------------------------------------------------------------------
|
| pembagian hak akses untuk local user organisasi
| 1 -> administrator atau admin organisasi alias [admin]
| 2 -> user dengan akses sebagai kepala desa alias [kades]
| 3 -> user dengan akses sebagai sekretaris desa alias [sekdes]
| 4 -> user dengan akses sebagai bendahara alias [bendahara]
| 5 -> user dengan akses sebagai bendahara pembantu pemasukan alias [user.bendahara.penerimaan]
| 6 -> user dengan akses sebagai bendahara pembantu pengeluaran alias [user.bendahara.pengeluaran]
|
| pembagian hak akses untuk sistem/monitoring/verifikator
| 100 -> user dengan akses sebagai bacak office/ pengelola sistem dalam lingkup kabupaten alias [backoffice]
| 200 -> user dengan akses sebagai bacak office/ pejabat pusat alias [pejabat.pusat]
| 300 -> user dengan akses sebagai bacak office/ pejabat provinsi alias [pejabat.provinsi]
| 400 -> user dengan akses sebagai bacak office/ pejabat kabupaten alias [pejabat.kabupaten]
| 500 -> user dengan akses sebagai bacak office/ pejabat kecamatan alais [pejabat.kecamatan]
|
*/

// Hak akses dengan alias [admin] akses yang diperbolehkan semuanya dan
// menu dashboard, menu pengaturan, menu managemen user dan user log
Route::filter('admin', function () {
    if (Auth::user()->is_admin != 1) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b> Administrator<b/>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// Menu RPJMDesa diakses oleh Kepala desa, Sekretaris Desa, Administrator
Route::filter('rpjmdesa', function () {
    if (Auth::user()->is_admin != 2 && Auth::user()->is_admin != 3 && Auth::user()->is_admin != 1) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>RPJMDesa</b>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// Menu standar satuan harga diakses oleh semua perangkat
Route::filter('perangkat', function () {
    if (Auth::user()->is_admin != 1 && Auth::user()->is_admin != 2 && Auth::user()->is_admin != 3 && Auth::user()->is_admin != 4  && Auth::user()->is_admin != 5  && Auth::user()->is_admin != 6) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Standar Satuan Harga</b>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// Menu RPJMDesa diakses oleh Kepala desa, Sekretaris Desa, Administrator
Route::filter('perdes', function () {
    if (Auth::user()->is_admin != 2 && Auth::user()->is_admin != 3 && Auth::user()->is_admin != 1) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Perdes</b> ,silahkan hubungi sistem administrator anda.']
        );
    }
});

// Menu RPJMDesa diakses oleh Kepala desa, Sekretaris Desa, Administrator
Route::filter('rkpdesa', function () {
    if (Auth::user()->is_admin != 2 && Auth::user()->is_admin != 3 && Auth::user()->is_admin != 1) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>RKPDesa</b>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// todo optimasi filter untuk bendahara, pembantu pengelauran dan pembantu penerimaan
// Menu Pembiayaan diakses oleh Bendahara, pembantu pengeluaran, pembantu penerimaan
// termasuk didalamnya transaksi pendapatan
Route::filter('pendapatan', function () {
    if (Auth::user()->is_admin != 1 && Auth::user()->is_admin != 4 && Auth::user()->is_admin != 5 && Auth::user()->is_admin != 6) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Pendapatan</b>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// Menu Pembiayaan diakses oleh Bendahara, pembantu pengeluaran, pembantu penerimaan
// termasuk didalamnya transaksi pengeluaran
Route::filter('belanja', function () {
    if (Auth::user()->is_admin != 1 && Auth::user()->is_admin != 4 && Auth::user()->is_admin != 5 && Auth::user()->is_admin != 6) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Belanja</b>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// Menu Pembiayaan diakses oleh Bendahara, pembantu pengeluaran, pembantu penerimaan
// termasuk didalamnya transaksi pembiayaan
Route::filter('pembiayaan', function () {
    if (Auth::user()->is_admin != 1 && Auth::user()->is_admin != 4 && Auth::user()->is_admin != 5 && Auth::user()->is_admin != 6) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Pembiayaan</b>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// filter global dari bendahara dibuat tersendiri untuk
// memudahkan dalam filter di mene sidebar dan juga
// proteksi dari routes, untuk efisiensi code

Route::filter('bendahara', function () {
    if (Auth::user()->is_admin != 1 && Auth::user()->is_admin != 4 && Auth::user()->is_admin != 5 && Auth::user()->is_admin != 6) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Bendahara</b>, silahkan hubungi sistem administrator anda.']
        );
    }
});

// Hak akses dengan alias [backoffice] akses yang diperbolehkan adalah
// Managemen Akun, Kewenangan, Provinsi,kabupaten, User, organisasi
// dukungan teknis/support, menu pengaturan yang berdampak global
Route::filter('backoffice', function () {
    if (Auth::user()->is_admin != 100) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Team Support</b>, silahkan hubungi sistem support anda.']
        );
    }
});

// Hak akses dengan alias [backoffice.admin] gabungan backoffice dengan admin
Route::filter('backoffice.admin', function () {
    if (Auth::user()->is_admin != 100 && Auth::user()->is_admin != 1 && Auth::user()->is_admin != 2) {
        return Redirect::to('dashboard')->with(
            ['message' => '<b>Administrator</b>, silahkan hubungi sistem support anda.']
        );
    }
});

// hak akses dengan alias [pejabat.pusat] akses yang diperbolehkan adalah
// untuk monitoring alur keuangan dari pusat ke daerah sampai ke desa
Route::filter('pejabat.pusat', function () {
    if (Auth::user()->is_admin != 200) {
        return Redirect::to('dashboard')->with(
            ['message' => 'silahkan hubungi sistem support anda.']
        );
    }
});

// hak akses dengan alias [pejabat.provinsi] akses yang diperbolehkan adalah
// untuk monitoring alur keuangan dari provinsi ke daerah sampai ke desa
Route::filter('pejabat.provinsi', function () {
    if (Auth::user()->is_admin != 300) {
        return Redirect::to('dashboard')->with(
            ['message' => 'silahkan hubungi sistem support anda.']
        );
    }
});

// hak akses dengan alias [pejabat.kabupaten] akses yang diperbolehkan adalah
// untuk monitoring alur keuangan dari kabupaten ke daerah sampai ke desa
Route::filter('pejabat.kabupaten', function () {
    if (Auth::user()->is_admin != 400) {
        return Redirect::to('dashboard')->with(
            ['message' => 'silahkan hubungi sistem support anda.']
        );
    }
});

// hak akses dengan alias [pejabat.kecamatan] akses yang diperbolehkan adalah
// untuk monitoring alur keuangan dari kabupaten ke daerah sampai ke desa
// dan juga sebagai ferifikator online untuk setiap proposal yg diajukan
Route::filter('pejabat.kecamatan', function () {
    if (Auth::user()->is_admin != 500) {
        return Redirect::to('dashboard')->with(
            ['message' => 'silahkan hubungi sistem support anda.']
        );
    }
});