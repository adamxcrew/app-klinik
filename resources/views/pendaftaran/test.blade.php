@extends('layouts.topnavlayout')
@section('title','Pendaftaran 111111')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Pendaftaran
        <small>PD-202111270004 </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-xs-6">
            <div class="box">
              <div class="box-body">
                  <h4>Biodata Pasien</h4>
                  <hr>

                  <table class="table table-bordered">
                      <tr>
                          <td rowspan="7">
                              <img src="data:image/png;base64,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">
                          </td>
                      </tr>
                      <tr>
                        <td>Nomor Rekamedis</td>
                        <td>MC00000001</td>
                    </tr>
                      <tr>
                          <td>Nama</td>
                          <td>Nuris Akbar</td>
                      </tr>
                      <tr>
                        <td>Tempat, Tgl Lhr</td>
                        <td>Langsa, 25 Agustus 1992</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>Nuris Akbar</td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>30 Tahun</td>
                    </tr>
                    <tr>
                        <td>Jenis Layanan</td>
                        <td>Pasien Umum</td>
                    </tr>
                    </table>

                  <h4>Daftar Kunjungan</h4>
                  <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Penjamin</th>
                        <th>Dokter</th>
                        <th>Poliklinik</th>
                        <th width="30"></th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1 Januari 2021</td>
                        <td>Umum</td>
                        <td>Dokter Asep</td>
                        <td>Polikli Gigi</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalHistoryPendaftaran">
                                <i class='fa fa-eye' aria-hidden='true'></i>
                              </button>
                              
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>22 Januari 2021</td>
                        <td>Umum</td>
                        <td>Dokter Gunawan</td>
                        <td>Polikli Gigi</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalHistoryPendaftaran">
                                <i class='fa fa-eye' aria-hidden='true'></i>
                              </button>
                              
                        </td>
                    </tr>
                </table>
                  <hr>

                  <button type="button" class="btn btn-danger btn-lg">Tandai Selesai Pelayanan</button>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="box">
              <div class="box-body">
                  <h4>Daftar Tindakan <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Input Tindakan
                  </button></h4>
                  <hr>
                  <table class="table table-bordered">
                      <tr>
                          <th>No</th>
                          <th>Kode ICD 9</th>
                          <th>Nama Tindakan</th>
                          <th>Fee</th>
                          <th width="30"></th>
                      </tr>
                      <tr>
                          <td>1</td>
                          <td>ABC</td>
                          <td>Konsultasi</td>
                          <td>1000</td>
                          <td><button class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>ABC</td>
                        <td>Konsultasi</td>
                        <td>1000</td>
                        <td><button class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
                    </tr>
                  </table>
                  <hr style="border:1px dashed">
                  <h4>Daftar Diagnosa <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Input Diganosa
                  </button></h4>
                  <hr>
                  <table class="table table-bordered">
                      <tr>
                          <th>No</th>
                          <th>Kode ICDController</th>
                          <th>Nama Diganosa</th>
                          <th width="30"></th>
                      </tr>
                      <tr>
                          <td>1</td>
                          <td>ABC</td>
                          <td>Konsultasi</td>
                          <td><button class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>ABC</td>
                        <td>Konsultasi</td>
                        <td><button class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
                    </tr>
                  </table>
                  <hr style="border:1px dashed">
                  <h4>Daftar Obat Racik <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Input Obat Racik
                  </button></h4>
                  <hr>
                  <table class="table table-bordered">
                      <tr>
                          <th>No</th>
                          <th>Nama Obat</th>
                          <th>Jumlah</th>
                          <th>Harga</th>
                          <th>Keterangan</th>
                          <th width="30"></th>
                      </tr>
                      <tr>
                          <td>1</td>
                          <td>Obat A</td>
                          <td>1</td>
                          <td>10000</td>
                          <td>Keterangan Contoh</td>
                          <td><button class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Obat B</td>
                        <td>1</td>
                        <td>10000</td>
                        <td>Keterangan Contoh</td>
                        <td><button class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
                    </tr>
                  </table>

                  <hr style="border:1px dashed">
                  <h4>Rujukan Laboratorium <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Input Rujukan
                  </button></h4>
                  <hr>
                  <table class="table table-bordered">
                      <tr>
                          <th>No</th>
                          <th>Dokter Perujuk</th>
                          <th>Nama Laporatorium</th>
                          <th>Jenis Pemeriksaan</th>
                          <th>Status</th>
                          <th width="30"></th>
                      </tr>
                      <tr>
                          <td>1</td>
                          <td>Nuris Abar</td>
                          <td>Laporatorium A</td>
                          <td>Gula Darah</td>
                          <td>Sedang Pemeriksaan</td>
                          <td><button class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button></td>
                      </tr>
                  </table>
                  <hr style="border:1px dashed">
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>

  <!-- Modal Tindakan -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal history pendafatran -->
<div class="modal fade" id="modalHistoryPendaftaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Riwayat Pelayanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection