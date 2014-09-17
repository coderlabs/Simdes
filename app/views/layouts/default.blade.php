<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta name="description" content="Sistem Informasi dan Managemen Keuangan Desa | Simdes | BBPMD Malang">
    <meta name="author" content="Edi Santoso, edicyber@gmail.com, @cyberid41">
    @if(1 == Config::get('app.debug'))
    <link rel="shortcut icon" href="{{ URL::asset('images/logo_simdes.png') }}">
    @else
    <link href="http://cdn.simdes-bbpmd.com/images/logo_simdes.png" rel="shortcut icon">
    @endif
    <title>@yield('title') | Simdes</title>

    {{--cdn untuk online--}}
    @if(1 == Config::get('app.debug'))
    {{ HTML::style('bs3/css/bootstrap.min.css') }}
    {{ HTML::style('css/bootstrap-reset.css') }}
    {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/style-responsive.css') }}
    {{ HTML::style('css/table-responsive.css') }}
    {{ HTML::style('css/refreshing.css') }}

    @else
    <link href="http://cdn.simdes-bbpmd.com/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="http://cdn.simdes-bbpmd.com/css/bootstrap-reset.css" rel="stylesheet" type="text/css" media="all" />
    {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
    <link href="http://cdn.simdes-bbpmd.com/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="http://cdn.simdes-bbpmd.com/css/style-responsive.css" rel="stylesheet" type="text/css" media="all" />
    <link href="http://cdn.simdes-bbpmd.com/css/table-responsive.css" rel="stylesheet" type="text/css" media="all" />
    <link href="http://cdn.simdes-bbpmd.com/css/refreshing.css" rel="stylesheet" type="text/css" media="all" />
    @endif

    @yield('style')
</head>
<body>
<!--contiainer-->
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        @include('includes.header')
    </header>
    <!--header end-->
    <aside>
        <div id="sidebar" class="headerNavbar nav-collapse">
            <!-- sidebar menu start-->
            @include('includes.left-sidebar')
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--main content start-->
    <section id="main-content">
        <div id='spinner'>
            <div>
                <div class='spinner'></div>
            </div>
        </div>
        @yield('content')

        @if(Auth::user()->is_organisasi == 0)
        <div class="alert alert-block alert-danger fade in " id="alert-notify">
            <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            <strong>Warning!</strong> Silahkan untuk input data <a href="{{URL::to('organisasi')}}">Data Umum</a>
            Terlebih dahulu!
        </div>
        @endif
    </section>
    <!--main content end-->
</section>
<!--container end-->

{{-- Deteksi jika debug true maka akan memakai local resource--}}
@if(1 == Config::get('app.debug'))
{{ HTML::script('js/lib/jquery.js') }}
{{ HTML::script('bs3/js/bootstrap.min.js') }}
{{ HTML::script('js/accordion-menu/jquery.dcjqaccordion.2.7.js') }}
{{ HTML::script('js/scrollTo/jquery.scrollTo.min.js') }}
{{ HTML::script('js/nicescroll/jquery.nicescroll.js') }}
{{ HTML::script('js/scripts.js') }}
{{ HTML::script('js/jquery.number.min.js') }}
{{ HTML::script('js/jquery-validate/jquery.validate.min.js') }}
@else
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/jquery.js"></script>
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/jquery.dcjqaccordion.2.7.js"></script>
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/scripts.js"></script>
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/jquery.number.min.js"></script>
<script type="text/javascript" src="http://cdn.simdes-bbpmd.com/js/jquery.validate.min.js"></script>
@endif

@yield('scripts')
</body>
</html>