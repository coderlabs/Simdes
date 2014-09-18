<!--logo start-->
<div class="brand">
    <div class="brand">
        @if(1 == Config::get('app.debug'))
        <img class="pull-left" src="{{ URL::asset('img/logo_organisasi.png') }}" alt="" height="60"
             style="margin-left: 20px; margin-top: 10px;">
        @else
        <img class="pull-left" src="http://cdn.simdes-bbpmd.com/img/logo_organisasi.png" alt="" height="60"
             style="margin-left: 20px; margin-top: 10px;">
        @endif

        <a href="{{ URL::to('/') }}" class="logo">
            @if(1 == Config::get('app.debug'))
            <img src="{{ URL::asset('images/logo_simdes.png') }}" alt="">
            @else
            <img src="http://cdn.simdes-bbpmd.com/images/logo_simdes.png" alt="">
            @endif
        </a>

        <ul class="nav pull-left top-menu">
            <li>
                <div id="refreshing-lg"  class="refreshing" style="border-top-width: 4px; margin-top: 24px;margin-left:10px; display:none;"></div>
            </li>
        </ul>

        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
</div>
<!--logo end-->
<div class="top-nav clearfix">

    <ul class="nav pull-right top-menu">

        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                @if(1 == Config::get('app.debug'))
                <img alt="" src="{{ URL::asset('images/avatar1_small.jpg') }}">
                @else
                <img alt="" src="http://cdn.simdes-bbpmd.com/images/avatar1_small.jpg" >
                @endif

                @if(Auth::check())
                <span class="username"> {{ Auth::user()->name}}</span>
                @else
                <span class="username">Not Logged!</span>
                @endif
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                @if(Auth::user()->is_admin == 100)
                <li>
                    <a href="{{URL::to('organisasi')}}"><i class=" fa fa-home"></i>Organisasi</a>
                </li>
                @endif
                <li>
                    <a href="{{URL::route('profile')}}"><i class=" fa fa-user"></i>Profil</a>
                </li>

                <li>
                    <a href="{{ URL::route("ganti.password") }}"><i class="fa fa-cog"></i> Settings</a>
                </li>
                <li>
                    <a href="{{ URL::route("auth.logout") }}"><i class="fa fa-key"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!--search & user info end-->
</div>