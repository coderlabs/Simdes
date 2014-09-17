@extends('layouts.error')
@section('title')
404 - Simdes 2014
@stop
@section('style')
@stop
@section('content')
<section class="error-wrapper text-center">
    <h1><img src="{{ URL::asset('images/404.png') }}" alt=""></h1>

    <div class="error-desk">
        <h2>halaman tidak ditemukan</h2>

        <p class="nrml-txt" style="font-size: 24px">Periksa URL, bisa jadi halaman tidak tersedia atau salah mengakses
            URL</p>
    </div>
    <a href="{{ URL::to('/') }}" class="back-btn"><i class="fa fa-home"></i> Kembali ke Dashboard</a>
</section>
@stop
@section('scripts')
@stop