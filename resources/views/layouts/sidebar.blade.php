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
        <li class="header">MAIN NAVIGATION</li>
        <?php
        $menus = [
          ['icon'=>'fa fa-user','link'=>'/home','label'=>'DASHBOARD'],
          ['icon'=>'fa fa-user-circle-o','link'=>'/pasien','label'=>'PASIEN'],
          ['icon'=>'fa fa-bars','link'=>'/home','label'=>'DATA MASTER','submenu'=>[
            ['icon'=>'fa fa-cube','link'=>'obat','label'=>'DATA OBAT'],
            ['icon'=>'fa fa-clone','link'=>'satuan','label'=>'DATA SATUAN']
          ]],
          ['icon'=>'fa fa-user-circle-o','link'=>'/user','label'=>'PENGGUNA APLIKASI']
        ];
        ?>

        @foreach($menus as $menu)
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