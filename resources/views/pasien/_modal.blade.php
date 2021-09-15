<!-- Modal Diagnosa Pasien-->
<div class="modal fade" id="modalDiagnosa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <div class="col-md-6">
              <h5 class="modal-title" id="exampleModalLabel">Daftar Diagnosa Pasien</h5>
            </div>
            <div class="col-md-6 text-right">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-striped" width="100%" id="diagnosa-table">
            <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Kode</th>
                  <th>Nama Diagnosa</th>
                  <th>#</th>
                </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Resep Pasien -->
<div class="modal fade" id="modalResep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <h5 class="modal-title" id="exampleModalLabel">Daftar Resep Pasien</h5>
          </div>
          <div class="col-md-6 text-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
      <div class="modal-body">
          <table class="table table-bordered table-striped" width="100%" id="obat-table">
            <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Kode</th>
                  <th>Nama Obat</th>
                  <th>#</th>
                </tr>
            </thead>
          </table>
      </div>
    </div>
  </div>
</div>


<!-- Modal Resep Obat Selanjutnya-->
<div class="modal fade" id="modalResepNext" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-arrow-left return-pilih-obat"></i> Daftar Resep Pasien</h5>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-6 text-right">
            3M Es Pe A4
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleFormControlInput1">Jumlah Obat</label>
          <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="0">
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput">Aturan Pakai</label>
          <input type="text" class="form-control" id="exampleFormControlInput" placeholder="EX : 2x1">
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Tindakan-->
<div class="modal fade" id="modalTindakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <h5 class="modal-title" id="exampleModalLabel">Daftar Tindakan</h5>
          </div>
          <div class="col-md-6 text-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" width="100%" id="tindakan-table">
          <thead>
              <tr>
                <th width="10">Nomor</th>
                <th>Kode</th>
                <th>Nama Tindakan</th>
                <th>#</th>
              </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>