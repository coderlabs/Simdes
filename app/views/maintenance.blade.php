@extends('layouts.error')
@section('title','Maintenance - Perbaikan')
@section('style')
@stop
@section('content')
<section class="error-wrapper text-center">
    <h1><img src="{{ URL::asset('images/maintenance.png') }}" alt=""></h1>

    <div class="">
        <h2>Maintenance</h2>

        <p class="nrml-txt" style="font-size: 24px">Mohon maaf, saat ini aplikasi SIMDES tidak bisa diakses, sedang ada perbaikan/maintenance</p>
    </div>
</section>
@stop
@section('scripts')
@stop