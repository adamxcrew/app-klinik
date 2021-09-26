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
        ['icon' => 'fa fa-address-card', 'link' => '/pendaftaran', 'label' => 'Data Pasien Antri'],
        ['icon' => 'fa fa-bars', 'link' => '/home', 'label' => 'Pendaftaran Pasien', 'submenu' => [
          ['icon' => 'fa fa-plus-square', 'link' => '/pasien/create', 'label' => 'Pasien Baru'],
          ['icon' => 'fa fa-plus-square-o', 'link' => '/pendaftaran/create', 'label' => 'Pasien Lama'],
          ['icon' => 'fa fa-list-ul', 'link' => '/pasien', 'label' => 'Database Pasien'],
        ]],
        ['icon' => 'fa fa-bars', 'link' => '/home', 'label' => 'Data Master', 'submenu' => [
          ['icon' => 'fa fa-clone', 'link' => '/satuan', 'label' => 'Data Satuan'],
          ['icon' => 'fa fa-hospital-o', 'link' => '/poliklinik', 'label' => 'Data Poliklinik'],
          ['icon' => 'fa fa-file-text', 'link' => '/diagnosa', 'label' => 'Data Diagnosa'],
          ['icon' => 'fa fa-file-text', 'link' => '/tindakan', 'label' => 'Data Tindakan'],
          ['icon' => 'fa fa-list-ul', 'link' => '/gejala', 'label' => 'Data Gejala'],
          ['icon' => 'fa fa-user-md', 'link' => '/user?jabatan=dokter', 'label' => 'Data Dokter'],
          ['icon' => 'fa fa-list-ul', 'link' => '/asuransi', 'label' => 'Data Perusahaan Asuransi'],
          ['icon' => 'fa fa-cube', 'link' => '/supplier', 'label' => 'Data Supplier'],

          ['icon' => 'fa fa-user-md', 'link' => '/kategori', 'label' => 'Data Kategori'],
          ['icon' => 'fa fa-user-md', 'link' => '/barang', 'label' => 'Data Barang'],
          ['icon' => 'fa fa-list-ul', 'link' => '/asuransi', 'label' => 'Perusahaan Asuransi'],
          ['icon' => 'fa fa-list-ul', 'link' => '/icd', 'label' => 'Data ICD'],
          ['icon' => 'fa fa-home', 'link' => '/kamar', 'label' => 'Data Kamar'],
          ['icon' => 'fa fa-bed', 'link' => '/bed', 'label' => 'Data Bed'],
        ]],
        ['icon' => 'fa fa-bars', 'link' => '#', 'label' => 'Laporan', 'submenu' => [
          ['icon' => 'fa fa-plus-square', 'link' => '/laporan/kunjungan-perpoli', 'label' => 'Kunjungan Perpoli'],
          ['icon' => 'fa fa-plus-square', 'link' => '/stock-opname', 'label' => 'Stock Opname']
        ]],

        ['icon' => 'fa fa-list-ul', 'link' => '/surat-sehat-sakit', 'label' => 'Data Surat Sehat Dan Sakit'],
        ['icon' => 'fa fa-bars', 'link' => '/home', 'label' => 'Transaksi Apotek', 'submenu' => [
          ['icon' => 'fa fa-cube', 'link' => '/purchase-order', 'label' => 'Purchase Order (PO)'],
          ['icon' => 'fa fa-plus-square', 'link' => '/purchase-order/create', 'label' => 'Tambah Purchase Order (PO)'],
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
        ['icon' => 'fa fa-user-circle-o', 'link' => '/pegawai', 'label' => 'Data Pegawai'],
        ['icon' => 'fa fa-money', 'link' => '/gaji', 'label' => 'Laporan Gaji'],
        ['icon' => 'fa fa-calendar-check-o', 'link' => '/harilibur', 'label' => 'Setting Hari Libur'],
        ['icon' => 'fa fa-id-card', 'link' => '/kehadiran-pegawai', 'label' => 'Kehadiran Pegawai'],
        ['icon' => 'fa fa-list-alt', 'link' => '/komponengaji', 'label' => 'Komponen Gaji']
      ];

      $keuangan = [
        ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
        ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Akun'],
        ['icon' => 'fa fa-user', 'link' => '/jurnal', 'label' => 'Jurnal Umum'],
        ['icon' => 'fa fa-book', 'link' => '/buku-besar', 'label' => 'Buku Besar'],
        ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Neraca Saldo'],
        ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Laporan'],
      ];

      $bagian_gudang = [
        ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
        ['icon' => 'fa fa-user', 'link' => '/purchase-order', 'label' => 'Purchase Order'],
        ['icon' => 'fa fa-user', 'link' => '/supplier', 'label' => 'Data Supplier'],
        ['icon' => 'fa fa-book', 'link' => '/stock-opname', 'label' => 'Stock Opname'],
        ['icon' => 'fa fa-user', 'link' => '/barang', 'label' => 'Master Barang'],
        ['icon' => 'fa fa-user', 'link' => '/kategori', 'label' => 'Master Kategori']
      ];

      // pengaturan menu berdasarkan level
      $menus = [
        'admin'           => $admin, 
        'dokter'          => [], 
        'kasir'           => $kasir, 
        'keuangan'        => $keuangan, 
        'hrd'             => $hrd,
        'bagian_gudang'   => $bagian_gudang
      ];
      ?>

      @foreach($menus[Auth::user()->role] as $menu)
      @if(array_key_exists('submenu',$menu))
      <li class="treeview">
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