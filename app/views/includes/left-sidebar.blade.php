<ul class="sidebar-menu" id="nav-accordion">
    <li>
        <a href="{{ URL::to('dashboard') }}" id="menu-dashboard">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>
    {{-- diakses oleh admin, kepala desa dan skretaris desa --}}
    @if(Auth::user()->is_admin != 1 && Auth::user()->is_admin != 2 && Auth::user()->is_admin != 3)
    @else
    <li class="sub-menu">
        <a href="javascript:;" id="a-perencanaan">
            <i class="fa fa-credit-card"></i>
            <span>Perencanaan</span>
        </a>
        <ul class="sub" id="li-perencanaan">
            <li id="menu-rpjmdesa"><a href="{{ URL::to('data-rpjmdesa') }}">RPJMDesa</a></li>
            <li id="menu-rkpdesa"><a href="{{ URL::to('data-rkpdesa') }}">RKPDesa</a></li>
        </ul>
    </li>
    @endif

    {{-- diakses oleh admin, skretaris desa bendahara desa--}}
    @if(Auth::user()->is_admin != 1 && Auth::user()->is_admin != 3 && Auth::user()->is_admin != 4)
    @else
    <li class="sub-menu">
        <a href="javascript:;" id="a-penganggaran">
            <i class="fa fa-list"></i>
            <span>Penganggaran</span>
        </a>
        <ul class="sub" id="li-penganggaran">
            <li id="menu-pendapatan"><a href="{{ URL::to('data-pendapatan') }}">Pendapatan</a></li>
            <li id="menu-belanja"><a href="{{ URL::to('data-belanja') }}">Belanja</a></li>
            <li id="menu-pembiayaan"><a href="{{ URL::to('data-pembiayaan') }}">Pembiayaan</a></li>
        </ul>
    </li>
    @endif

    {{-- diakses oleh admin, kepala desa dan skretaris desa --}}
    @if(Auth::user()->is_admin != 1 && Auth::user()->is_admin != 2 && Auth::user()->is_admin != 3)
    @else
    <li class="sub-menu">
        <a href="javascript:;" id="a-dokumen">
            <i class="fa fa-copy"></i>
            <span>Dokumen Pelaksanaan</span>
        </a>
        <ul class="sub" id="li-dokumen">
            <li id="menu-rka"><a href="{{ URL::to('data-rka-desa') }}">RKA Desa</a></li>
            <li id="menu-dpa"><a href="{{ URL::to('data-dpa-desa') }}">DPA Desa</a></li>
        </ul>
    </li>
    @endif

     {{--diakses oleh admin, bendahara desa, pembantu penerimaan--}}
    @if(Auth::user()->is_admin != 1 && Auth::user()->is_admin != 4 && Auth::user()->is_admin != 5)
    @else
    <li class="sub-menu">
        <a href="javascript:;" id="a-penatausahaan">
            <i class="fa fa-table"></i>
            <span>Penatausahaan Penerimaan</span>
        </a>
        <ul class="sub" id="li-penatausahaan">
            <li id="menu-tr-pendapatan"><a href="{{ URL::to('data-tr-pendapatan') }}">Transaksi</a></li>
            <li id="menu-mutasi"><a href="{{ URL::to('data-mutasi-kas-bank') }}">Mutasi Kas - Bank</a></li>
            <li id="menu-bku-pendapatan"><a href="{{ URL::to('laporan-bku-pendapatan') }}">Bukti Transaksi</a></li>
        </ul>
    </li>
    @endif

    {{-- diakses oleh admin, bendahara desa, pembantu penerimaan--}}
    @if(Auth::user()->is_admin != 1 && Auth::user()->is_admin != 4 && Auth::user()->is_admin != 6)
    @else
    <li class="sub-menu">
        <a href="javascript:;" id="a-penatausahaan-pengeluaran">
        <i class="fa fa-table"></i>
            <span>Penatausahaan Pengeluaran</span>
        </a>
        <ul class="sub" id="li-penatausahaan-pengeluaran">
            <li id="menu-tr-belanja"><a href="{{ URL::to('data-tr-belanja') }}">Transaksi</a></li>
            <li id="menu-mutasi"><a href="{{ URL::to('data-mutasi-bank-kas') }}">Mutasi Bank - Kas</a></li>
            <li id="menu-bku-belanja"><a href="{{ URL::to('laporan-bku-belanja') }}">Bukti Transaksi</a></li>
        </ul>
    </li>
    @endif

    {{-- diakses oleh backoffice--}}
    @if(Auth::user()->is_admin != 100)
    @else
    <li class="sub-menu">
        <a id="a-struktur" href="javascript:;">
            <i class="fa fa-sitemap"></i>
            <span>Struktur</span>
        </a>
        <ul class="sub" id="li-struktur">
            <li id="menu-akun"><a href="{{URL::to('data-akun')}}">APBDes</a></li>
            <li id="menu-kewenangan"><a href="{{URL::to('data-kewenangan')}}">Kewenangan</a></li>
        </ul>
    </li>

    <li class="sub-menu">
        <a id="a-master" href="javascript:;">
            <i class="fa fa-list-alt"></i>
            <span>Master Data</span>
        </a>
        <ul class="sub" id="li-master">
            <li id="list-organisasi"><a href="{{ URL::to('data-list-organisasi') }}">List Organisasi</a></li>
            <li id="list-user"><a href="{{ URL::to('data-list-user') }}">List User</a></li>
            <li id="menu-prov"><a href="{{ URL::to('master-provinsi') }}">Provinsi</a></li>
            <li id="menu-kab"><a href="{{ URL::to('master-kabupaten') }}">Kabupaten</a></li>
            <li id="menu-ssh"><a href="{{ URL::to('data-kelas-barang') }}">Standar Satuan Harga</a></li>
        </ul>
    </li>
    @endif

    {{-- diakses oleh admin, kepala desa, sekretaris desa--}}
    @if(Auth::user()->is_admin != 1 && Auth::user()->is_admin != 2 && Auth::user()->is_admin != 3)
    @else
    <li class="sub-menu">
        <a id="a-perangkat" href="javascript:;">
            <i class="fa fa-briefcase"></i>
            <span>Perangkat</span>
        </a>
        <ul class="sub" id="li-perangkat">
            <li id="menu-perdes"><a href="{{ URL::to('data-perdes-judul') }}">Peraturan Desa</a></li>
            <li id="menu-akun"><a href="{{URL::to('data-obyek')}}">APBDes</a></li>
            <li id="menu-kewenangan"><a href="{{URL::to('data-program-kewenangan')}}">Kewenangan</a></li>
        </ul>
    </li>
    @endif

    {{-- diakses oleh admin, kepala desa, sekretaris desa--}}
    @if(Auth::user()->is_admin != 1)
    @else
    <li class="sub-menu">
        <a id="a-pengaturan" href="javascript:;" id="a-pengaturan">
            <i class="fa fa-gear"></i>
            <span>Pengaturan</span>
        </a>
        <ul class="sub" id="li-pengaturan">
            <li id="menu-organisasi"><a href="{{ URL::to('organisasi') }}">Data Umum Desa</a></li>
            <li><a href="#">Organisasi</a></li>
            <li id="menu-pejabat-desa"><a href="{{ URL::to('tim-anggaran') }}">Tim Anggaran</a></li>
            <li id="menu-user"><a href="{{ URL::to('data-user') }}">Managemen User</a></li>

            {{--<li id="menu-user-log"><a href="{{ URL::to('user-log') }}">Aktifitas User</a></li>--}}
        </ul>
    </li>
    @endif
     <li>
         <a href="{{ URL::to('standar-satuan-harga-barang') }}" id="menu-ssh-barang">
             <i class="fa fa-shopping-cart"></i>
             <span>Standar Satuan Harga</span>
         </a>
     </li>
</ul>