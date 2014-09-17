<!doctype html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Home | Simdes</title>
    <meta name="description" content="Home - landing page" />
    <meta name="keywords" content="simdes, bbpmd malang, malang">
    <meta property="og:title" content="">

    {{ HTML::style('landing/css/bootstrap.min.css') }}
    {{ HTML::style('landing/fancybox/jquery.fancybox-v=2.1.5.css',['medai' => 'screen']) }}
    {{ HTML::style('landing/css/font-awesome.min.css') }}
    {{ HTML::style('landing/css/style.css') }}
    {{ HTML::style('landing/images/zoom.png') }}
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,300,200&subset=latin,latin-ext'
          rel='stylesheet' type='text/css'>
</head>

<body>
<div class="navbar navbar-fixed-top" data-activeslide="1">
    <div class="container">

        <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>


        <div class="nav-collapse collapse navbar-responsive-collapse">
            <ul class="nav row">
                <li data-slide="1" class="col-12 col-sm-2"><a id="menu-link-1" href="#slide-1"
                                                              title="Next Section"><span class="icon icon-home"></span>
                        <span class="text">BERANDA</span></a></li>
                <li data-slide="2" class="col-12 col-sm-2"><a id="menu-link-2" href="#slide-2"
                                                              title="Next Section"><span class="icon icon-user"></span>
                        <span class="text">TENTANG KAMI</span></a></li>
                <li data-slide="3" class="col-12 col-sm-2"><a id="menu-link-3" href="#slide-3"
                                                              title="Next Section"><span
                            class="icon icon-briefcase"></span> <span class="text">PORTFOLIO</span></a></li>
                <li data-slide="4" class="col-12 col-sm-2"><a id="menu-link-4" href="#slide-4"
                                                              title="Next Section"><span class="icon icon-gears"></span>
                        <span class="text">FITUR</span></a></li>
                <li data-slide="5" class="col-12 col-sm-2"><a id="menu-link-5" href="#slide-5"
                                                              title="Next Section"><span class="icon icon-heart"></span>
                        <span class="text">Dukungan</span></a></li>
                <li data-slide="6" class="col-12 col-sm-2"><a id="menu-link-6" href="#slide-6"
                                                              title="Next Section"><span
                            class="icon icon-envelope"></span> <span class="text">KONTAK</span></a></li>
            </ul>
            <div class="row">
                <div class="col-sm-2 active-menu"></div>
            </div>
        </div>
        <!-- /.nav-collapse -->
    </div>
    <!-- /.container -->
</div>
<!-- /.navbar -->


<!-- === Arrows === -->
<div id="arrows">
    <div id="arrow-up" class="disabled"></div>
    <div id="arrow-down"></div>
    <div id="arrow-left" class="disabled visible-lg"></div>
    <div id="arrow-right" class="disabled visible-lg"></div>
</div>
<!-- /.arrows -->


<!-- === MAIN Background === -->
<div class="slide story" id="slide-1" data-slide="1">
    <div class="container">
        <div id="home-row-1" class="row clearfix">
            <div class="col-12">
                <h4 class="font-thin">Kenapa saya melihat ini? Aplikasi <span class="font-semibold">SIMDES</span> sedang dalam  <span class="font-semibold">MAINTENANCE</span>
                <span class="font-thin">Silahkan kembali beberapa waktu lagi, kami sedang menambahkan fitur</span><br/>
                <span class="font-thin">- Terima kasih -</span>
                </h4>
                <h1 class="font-semibold">APLIKASI <span class="font-thin">SIMDES</span></h1>
                <h4 class="font-thin">Sistim Informasi dan Managemen Keuangan Desa</h4>
            </div>
            <!-- /col-12 -->
        </div>
        <!-- /row -->
        <div id="home-row-2" class="row clearfix">
            <div class="col-12 col-sm-4">
                <div class="home-hover navigation-slide" data-slide="4"><img src="landing/images/s02.png"></div>
                <span>PROFESSIONAL</span></div>
            <div class="col-12 col-sm-4">
                <div class="home-hover navigation-slide" data-slide="3"><img src="landing/images/s01.png"></div>
                <span>FRIENDLY</span></div>
            <div class="col-12 col-sm-4">
                <div class="home-hover navigation-slide" data-slide="5"><img src="landing/images/s03.png"></div>
                <span>SUITABLE</span></div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /slide1 -->

<!-- === Slide 2 === -->
<div class="slide story" id="slide-2" data-slide="2">
    <div class="container">
        <div class="row title-row">
            <div class="col-12 font-thin">Kami adalah IT Profesional yang bermitra dengan Balai Besar Pemberdayaan Masyarakat Desa
                <span class="font-semibold">(BBPMD)</span> Malang.
            </div>
        </div>
        <!-- /row -->
        <div class="row line-row">
            <div class="hr">&nbsp;</div>
        </div>
        <!-- /row -->
        <div class="row subtitle-row">
            <div class="col-12 font-thin">Kami berkomitmen untuk <span class="font-semibold">memberikan yang terbaik</span></div>
        </div>
        <!-- /row -->
        <div class="row content-row">
            <div class="col-12 col-lg-3 col-sm-6">
                <p><i class="icon icon-eye-open"></i></p>
                <h2 class="font-thin">Interface yang  <span class="font-semibold">user friendly</span></h2>
                <h4 class="font-thin">Kami berupaya menyajikan tampilan program/software yang mudah dipelajari.</h4>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-lg-3 col-sm-6">
                <p><i class="icon icon-laptop"></i></p>

                <h2 class="font-thin">Tampilan/design <span class="font-semibold">yang menarik</span></h2>
                <h4 class="font-thin">Memberikan pengalaman yang menarik disisi tampilan/design yang membuat anda menjadi senang.</h4>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-lg-3 col-sm-6">
                <p><i class="icon icon-list"></i></p>

                <h2 class="font-thin">Dokumen <span class="font-semibold">Pelaksana</span></h2>
                <h4 class="font-thin">Format dokumen yang kami dukung dalam format PDF, dan ready untuk di cetak seperti Dokumen RKA/DPA, perdes APBDes, perdes RPJMDes.</h4>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-lg-3 col-sm-6">
                <p><i class="icon icon-heart-empty"></i></p>

                <h2 class="font-semibold">Development is Enjoy</h2>
                <h4 class="font-thin">Kami selalu mendengar keluhan anda, kami mengembangkan Aplikasi Simdes dengan penuh semangat.</h4>
            </div>
            <!-- /col12 -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /slide2 -->

<!-- === SLide 3 - Portfolio -->
<div class="slide story" id="slide-3" data-slide="3">
    <div class="row">
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/dashboard.png"><img class="thumb"
                                                                                            src="images/dashboard-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/rpjmdesa.png"><img class="thumb"
                                                                                            src="images/rpjmdesa-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/program.png"><img class="thumb"
                                                                                            src="images/program-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/apbdesa-jenis.png"><img class="thumb"
                                                                                             src="images/apbdesa-jenis-mini.png"
                                                                                             alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/apbdesa-obyek.png"><img class="thumb"
                                                                                            src="images/apbdesa-obyek-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/cetak-rpjmdesa.png"><img class="thumb"
                                                                                            src="images/cetak-rpjmdesa-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/cetak-rkpdesa.png"><img class="thumb"
                                                                                            src="images/cetak-rkpdesa-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/data-umum-desa.png"><img class="thumb"
                                                                                            src="images/data-umum-desa-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/ssh.png"><img class="thumb"
                                                                                            src="images/ssh-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/data-rka.png"><img class="thumb"
                                                                                            src="images/data-rka-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/data-dpa.png"><img class="thumb"
                                                                                            src="images/data-dpa-mini.png"
                                                                                            alt=""></a></div>
        <div class="col-12 col-sm-6 col-lg-2"><a data-fancybox-group="portfolio" class="fancybox"
                                                 href="images/detil-rkpdesa.png"><img class="thumb"
                                                                                            src="images/detil-rkpdesa-mini.png"
                                                                                            alt=""></a></div>
    </div>
    <!-- /row -->
</div>
<!-- /slide3 -->

<!-- === Slide 4 - Process === -->
<div class="slide story" id="slide-4" data-slide="4">
    <div class="container">
        <div class="row title-row">
            <div class="col-12 font-thin">Lihat fitur <span class="font-semibold">yang kami sajikan di Aplikasi Simdes</span></div>
        </div>
        <!-- /row -->
        <div class="row line-row">
            <div class="hr">&nbsp;</div>
        </div>
        <!-- /row -->
        <div class="row subtitle-row">
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
            <div class="col-12 col-sm-10 font-thin">
                Kami menyajikan fitur di aplikasi Simdes yang terbaru sesuai dengan amanat PP 43 Tahun 2014, kami menyediakan Standar Satuan Harga (SSH) sesui dengan Kabupaten/Kota.
                Dokumen Pelaksana Anggaran RKA/DPA dan Perdes RPJMDesa/APBDes tanpa mebuat ulang atau memformat ulang, kami sesuaikan dengan ketentuan yang berlaku.
            </div>
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
        </div>
        <!-- /row -->
        <div class="row content-row">
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
            <div class="col-12 col-sm-3">
                <p><i class="icon icon-bolt"></i></p>

                <h2 class="font-thin">Mendengar <br><span class="font-semibold">kebutuhan anda</span></h2>
                <h4 class="font-thin">
                    Kami IT profesional berupaya memberikan pelayanan ayng terbaik, kami selalu mendengarkan kebutuhan anda.</h4>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-sm-3">
                <p><i class="icon icon-cog"></i></p>

                <h2 class="font-thin">Project<br><span class="font-semibold">discovery</span></h2>
                <h4 class="font-thin">
                    Kami didukung oleh para profesional dibidangnya, perpaduan antara ahli Produk Hukum dan ahli IT.</h4>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-sm-3">
                <p><i class="icon icon-cloud"></i></p>

                <h2 class="font-thin">Selalu <br><span class="font-semibold">Online</span></h2>
                <h4 class="font-thin">
                    Kami memantau secara penuh aplikasi Simdes agar tetap online, agar kegiatan anda tetap berjalan.</h4>
            </div>
            <!-- /col12 -->
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /slide4 -->

<!-- === Slide 5 === -->
<div class="slide story" id="slide-5" data-slide="5">
    <div class="container">
        <div class="row title-row">
            <div class="col-12 font-thin"><span class="font-semibold">Dukungan</span> penuh</div>
        </div>
        <!-- /row -->
        <div class="row line-row">
            <div class="hr">&nbsp;</div>
        </div>
        <!-- /row -->
        <div class="row subtitle-row">
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
            <div class="col-12 col-sm-10 font-light">
                Kami memberikan dukungan penuh agar Aplikasi Simdes berjalan dengan lancar, menjawab pertanyaan user.
                Kami menyediakan pelatihan intensif, baik yang di selenggarakan oleh Balai Besar PMD atau secara khusus ke daerah.<br/>
                Kami menyediakan dokumentasi aplikasi manual dalam format pdf dan video tutorial.
            </div>
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /slide5 -->

<!-- === Slide 6 / Contact === -->
<div class="slide story" id="slide-6" data-slide="6">
    <div class="container">
        <div class="row title-row">
            <div class="col-12 font-light">Tinggalkan  <span class="font-semibold">pesan</span></div>
        </div>
        <!-- /row -->
        <div class="row line-row">
            <div class="hr">&nbsp;</div>
        </div>
        <!-- /row -->
        <div class="row subtitle-row">
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
            <div class="col-12 col-sm-10 font-light">
                Anda dapat menghubungi kami dengan beberapa cara dan kontak di bawah ini:
            </div>
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
        </div>
        <!-- /row -->
        <div id="contact-row-4" class="row">
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
            <div class="col-12 col-sm-2 with-hover-text">
                <p><a href="javascript:;"><i class="icon icon-phone"></i></a></p>
                <span class="hover-text font-light ">0341 86 444 84</span></a>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-sm-2 with-hover-text">
                <p><a target="_blank" href="mailto:info@simdes-bbpmd.com"><i class="icon icon-envelope"></i></a></p>
                <span class="hover-text font-light ">info@simdes-bbpmd.com</span></a>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-sm-2 with-hover-text">
                <p><a href="javascript:;"><i class="icon icon-home"></i></a></p>
                <span class="hover-text font-light ">Kepanjen, Malang<br>kode pos 65163</span></a>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-sm-2 with-hover-text">
                <p><a target="_blank" href="https://www.facebook.com/cyberid41"><i class="icon icon-facebook"></i></a></p>
                <span class="hover-text font-light ">facebook/cyberid41</span></a>
            </div>
            <!-- /col12 -->
            <div class="col-12 col-sm-2 with-hover-text">
                <p><a target="_blank" href="https://twitter.com/cyberid41"><i class="icon icon-twitter"></i></a></p>
                <span class="hover-text font-light ">@cyberid41</span></a>
            </div>
            <!-- /col12 -->
            <div class="col-sm-1 hidden-sm">&nbsp;</div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /Slide 6 -->

</body>

<!-- SCRIPTS -->
{{ HTML::script('landing/js/html5shiv.js') }}
{{ HTML::script('landing/js/jquery-1.10.2.min.js') }}
{{ HTML::script('landing/js/jquery-migrate-1.2.1.min.js') }}
{{ HTML::script('landing/js/bootstrap.min.js') }}
{{ HTML::script('landing/js/jquery.easing.1.3.js') }}
{{ HTML::script('landing/fancybox/jquery.fancybox.pack-v=2.1.5.js') }}
{{ HTML::script('landing/js/script.js') }}

<!-- fancybox init -->
<script>
    $(document).ready(function (e) {
        var lis = $('.nav > li');
        menu_focus(lis[0], 1);
        $(".fancybox").fancybox({
            padding: 10,
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
    });
</script>

</html>