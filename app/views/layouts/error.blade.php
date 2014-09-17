<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="<edicyber@gmail.com>">
		<link rel="shortcut icon" href="{{ URL::asset('images/logo_simdes.png') }}">
		<title>@yield('title') | Simdes</title>
		<!--Core CSS Aplication -->
        {{--cdn untuk online--}}
        @if(1 == Config::get('app.debug'))
        {{ HTML::style('bs3/css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-reset.css') }}
        {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
        {{ HTML::style('css/style.css') }}
        {{ HTML::style('css/style-responsive.css') }}
        @else
        <link href="http://cdn.simdes-bbpmd.com/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="http://cdn.simdes-bbpmd.com/css/bootstrap-reset.css" rel="stylesheet" type="text/css" media="all" />
        {{ HTML::style('assets/font-awesome/css/font-awesome.css') }}
        <link href="http://cdn.simdes-bbpmd.com/css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="http://cdn.simdes-bbpmd.com/css/style-responsive.css" rel="stylesheet" type="text/css" media="all" />
        @endif
		@yield('style')
	</head>
	<body class="body-404">
		<div class="error-head"> </div>
		<div class="container ">
			<!--main content start-->
			@yield('content')
			<!--main content end-->
		</div>
		<!--container end-->
	</body>
</html>