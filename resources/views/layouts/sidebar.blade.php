<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU UTAMA</li>
      <?php
      $admin = [
        ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
        ['icon' => 'fa fa-user-circle-o', 'link' => '/pasien', 'label' => 'Data Pasien'],
        ['icon' => 'fa fa-bars', 'link' => '/home', 'label' => 'Data Master', 'submenu' => [
          ['icon' => 'fa fa-cube', 'link' => '/obat', 'label' => 'Data Obat'],
          ['icon' => 'fa fa-clone', 'link' => '/satuan', 'label' => 'Data Satuan'],
          ['icon' => 'fa fa-building', 'link' => '/poliklinik', 'label' => 'Data Poliklinik'],
          ['icon' => 'fa fa-file-text', 'link' => '/diagnosa', 'label' => 'Data Diagnosa'],
          ['icon' => 'fa fa-list-ul', 'link' => '/gejala', 'label' => 'Data Gejala'],
          ['icon' => 'fa fa-user-md', 'link' => '/user?jabatan=dokter', 'label' => 'Data Dokter']
        ]],
        ['icon' => 'fa fa-user-circle-o', 'link' => '/user?jabatan=user', 'label' => 'Pengguna Aplikasi'],
        ['icon' => 'fa fa-gear', 'link' => '/setting', 'label' => 'Setting Aplikasi']
      ];

      $kasir = [
        ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
        ['icon' => 'fa fa-user-circle-o', 'link' => '/pasien', 'label' => 'Pembayaran']
      ];

      $hrd = [
        ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
        ['icon' => 'fa fa-user-circle-o', 'link' => '/pegawai', 'label' => 'Pegawai'],
        ['icon' => 'fa fa-dollar', 'link' => '/gaji', 'label' => 'Gaji']
      ];

      $keuangan = [
        ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
        ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Akun'],
        ['icon' => 'fa fa-user', 'link' => '/jurnal', 'label' => 'Jurnal Umum'],
        ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Buku Besar'],
        ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Neraca Saldo'],
        ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Laporan'],
      ];

      $menus = ['admin' => $admin, 'dokter' => [], 'kasir' => $kasir, 'keuangan' => $keuangan, 'hrd' => $hrd];
      ?>

      @foreach($menus[Auth::user()->role] as $menu)
      @if(array_key_exists('submenu',$menu))
      <li class="active treeview">
        <a href="#">
          <i class="{{$menu['icon']}}"></i> <span>{{$menu['label']}}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <!-- add class active to adcvivated menu -->
          @foreach ($menu['submenu'] as $submenu)
          <li><a href="{{$submenu['link']}}"><i class="{{$submenu['icon']}}"></i> {{$submenu['label']}}</a></li>
          @endforeach

        </ul>
      </li>
      @else
      <li><a href="{{$menu['link']}}"><i class="{{$menu['icon']}}"></i> <span>{{$menu['label']}}</span></a></li>
      @endif
      @endforeach
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>