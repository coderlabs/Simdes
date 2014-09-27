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
    <link rel="shortcut icon" href="{{ URL::asset('images/logo_simdes.png') }}">
    <title>@yield('title') | Simdes</title>

    {{--required style for all pages--}}
    {{ HTML::style('bs3/css/bootstrap.min.css') }}
    {{ HTML::style('css/bootstrap-reset.css') }}
    {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/style-responsive.css') }}
    {{ HTML::style('css/table-responsive.css') }}
    {{ HTML::style('css/refreshing.css') }}
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
    </section>
    <!--main content end-->
</section>
<!--container end-->

{{ HTML::script('js/lib/jquery.js') }}
{{ HTML::script('bs3/js/bootstrap.min.js') }}
{{ HTML::script('js/accordion-menu/jquery.dcjqaccordion.2.7.js') }}
{{ HTML::script('js/scrollTo/jquery.scrollTo.min.js') }}
{{ HTML::script('js/nicescroll/jquery.nicescroll.js') }}
{{ HTML::script('js/scripts.js') }}
{{ HTML::script('js/jquery.number.min.js') }}
{{ HTML::script('js/jquery-validate/jquery.validate.min.js') }}

@yield('scripts')
</body>
</html>