@extends('layouts.default')
@section('title')
Dashboard
@stop
@section('style')
<link href="assets/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
<link href="css/clndr.css" rel="stylesheet">
<!--clock css-->
<link href="assets/css3clock/css/style.css" rel="stylesheet">
<!--Morris Chart CSS -->
<link rel="stylesheet" href="assets/morris-chart/morris.css">
@stop
@section('content')
<section class="wrapper">
    <!--mini statistics start-->
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5>Maaf anda tidak diperkenankan untuk mengakses halaman : {{Session::get('message')}}</h5>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="top-stats-panel">
                        <div class="daily-visit">
                            <h4 class="widget-h">Anggaran Pendapatan</h4>

                            <div id="pendapatan" style="width:100%; height: 100px; display: block">

                            </div>
                            <ul class="chart-meta clearfix">
                                <li class="pull-left visit-chart-value">190 Item</li>
                                <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 65%</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="top-stats-panel">
                        <div class="daily-visit">
                            <h4 class="widget-h">Anggaran Belanja</h4>

                            <div id="belanja" style="width:100%; height: 100px; display: block">

                            </div>
                            <ul class="chart-meta clearfix">
                                <li class="pull-left visit-chart-value">233 item</li>
                                <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 55%</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="top-stats-panel">
                        <div class="daily-visit">
                            <h4 class="widget-h">Anggaran Pembiayaan</h4>

                            <div id="biaya" style="width:100%; height: 100px; display: block">

                            </div>
                            <ul class="chart-meta clearfix">
                                <li class="pull-left visit-chart-value">178 item</li>
                                <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 25%</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="top-stats-panel">
                        <div class="gauge-canvas">
                            <h4 class="widget-h">Neraca</h4>
                            <canvas width=160 height=100 id="gauge"></canvas>
                        </div>
                        <ul class="gauge-meta clearfix">
                            <li id="gauge-textfield" class="pull-left gauge-value"></li>
                            <li class="pull-right gauge-title">Aman</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!--mini statistics end-->
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="top-stats-panel">
                        <div class="daily-visit">
                            <h4 class="widget-h">Jurnal Harian</h4>

                            <div id="besar" style="width:100%; height: 100px; display: block">

                            </div>
                            <ul class="chart-meta clearfix">
                                <li class="pull-left visit-chart-value">1233 item</li>
                                <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 29%</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
</section>
@stop
@section('scripts')
{{ HTML::script('app/dashboard.js') }}

@if(1 == Config::get('app.debug'))
<script src="assets/skycons/skycons.js"></script>
<script src="assets/jquery.scrollTo/jquery.scrollTo.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="assets/calendar/clndr.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="assets/calendar/moment-2.2.1.js"></script>
<script src="js/calendar/evnt.calendar.init.js"></script>
<script src="assets/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="assets/gauge/gauge.js"></script>
<!--clock init-->
<script src="assets/css3clock/js/script.js"></script>
<!--Easy Pie Chart-->
<script src="assets/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="assets/sparkline/jquery.sparkline.js"></script>
<!--Morris Chart-->
<script src="assets/morris-chart/morris.js"></script>
<script src="assets/morris-chart/raphael-min.js"></script>
<!--jQuery Flot Chart-->
<script src="assets/flot-chart/jquery.flot.js"></script>
<script src="assets/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="assets/flot-chart/jquery.flot.resize.js"></script>
<script src="assets/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="assets/flot-chart/jquery.flot.animator.min.js"></script>
<script src="assets/flot-chart/jquery.flot.growraf.js"></script>
<script src="js/dashboard.js"></script>
<script src="js/custom-select/jquery.customSelect.min.js"></script>
@else
<script src="http://cdn.simdes-bbpmd.com/assets/skycons/skycons.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/jquery.scrollTo/jquery.scrollTo.js"></script>
<script
    src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/calendar/clndr.js"></script>
<script
    src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/calendar/moment-2.2.1.js"></script>
<script src="http://cdn.simdes-bbpmd.com/js/calendar/evnt.calendar.init.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/gauge/gauge.js"></script>
<!--clock init-->
<script src="http://cdn.simdes-bbpmd.com/assets/css3clock/js/script.js"></script>
<!--Easy Pie Chart-->
<script src="http://cdn.simdes-bbpmd.com/assets/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="http://cdn.simdes-bbpmd.com/assets/sparkline/jquery.sparkline.js"></script>
<!--Morris Chart-->
<script src="http://cdn.simdes-bbpmd.com/assets/morris-chart/morris.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/morris-chart/raphael-min.js"></script>
<!--jQuery Flot Chart-->
<script src="http://cdn.simdes-bbpmd.com/assets/flot-chart/jquery.flot.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/flot-chart/jquery.flot.resize.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/flot-chart/jquery.flot.animator.min.js"></script>
<script src="http://cdn.simdes-bbpmd.com/assets/flot-chart/jquery.flot.growraf.js"></script>
<script src="http://cdn.simdes-bbpmd.com/js/dashboard.js"></script>
<script src="http://cdn.simdes-bbpmd.com/js/custom-select/jquery.customSelect.min.js"></script>
@endif

@stop