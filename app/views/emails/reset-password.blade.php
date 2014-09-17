<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Email Konfirmasi Reset Password</h2>

<p>Anda telah mendaftar di Aplikasi Sistem Informasi dan Manajemen Keuangan Desa [SIMDES], berikut detail akun anda:</p>
<table width="100%">
    <tr style="vertical-align: top">
        <td width="20%">Nama :</td>
        <td width="80%">{{$nama}}</td>
    </tr>
    <tr style="vertical-align: top">
        <td>Email :</td>
        <td>{{$email}}</td>
    </tr>
    <tr style="vertical-align: top">
        <td>Password :</td>
        <td>password anda</td>
    </tr>
    <tr style="vertical-align: top">
        <td>URL Login :</td>
        <td><a href="http://simdes-bbpmd.com/login">http://simdes-bbpmd.com/login</a></td>
    </tr>
    <tr style="vertical-align: top">
        <td>URL Aktifasi :</td>
        <td>
            @if(isset($remember_token))
            Gunakan link berikut untuk reset password anda, jika tidak bekerja copy dan pastekan ke URL browser anda
            <a href="http://simdes-bbpmd.com/get-reset-password/{{$email}}/{{($remember_token) ? $remember_token : 'anda belum pernah login ke sistem'}}">http://simdes-bbpmd.com/get-reset-password/{{$email}}/{{($remember_token) ? $remember_token : 'anda belum pernah login ke sistem'}}</a>
            @else
            Anda belum pernah login ke sistem, silahkan menghubungi <a href="mailto:info@simdes-bbpmd.com" target="_self">info@simdes-bbpmd.com</a> untuk mengaktifkan akun anda.
            @endif
        </td>
    </tr>
</table>
</body>
</html>