<ul class="nav nav-tabs">
    <li class="nav-item {{ Request::segment(4)=='tindakan'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/tindakan">Pemberian Tindakan</a>
    </li>
    <li class="nav-item {{ Request::segment(4)=='diagnosa'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/diagnosa">Input Diagnosa</a>
    </li>
    <li class="nav-item {{ Request::segment(4)=='resep'?'active':'' }}">
      <a class="nav-link" href="/pendaftaran/{{ $pendaftaran->id }}/pemeriksaan/resep">Pemberian Resep</a>
    </li>
  </ul>
  