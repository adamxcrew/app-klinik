<!-- Modal Diagnosa Pasien-->
<div class="modal fade" id="modalDiagnosa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Daftar Diagnosa Pasien</h5>
        </div>
        <div class="modal-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kode</th>
                <th scope="col">Nama Diagnosa</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td><button class="btn btn-danger btn-sm">Tambahkan</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Resep Pasien -->
<div class="modal fade" id="modalResep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daftar Resep Pasien</h5>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kode</th>
                <th scope="col">Nama Obat</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td><button class="btn btn-danger btn-sm button-pilih-obat">Pilih</button></td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>


<!-- Modal Resep Obat Selanjutnya-->
<div class="modal fade" id="modalResepNext" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-arrow-left return-pilih-obat"></i> Daftar Resep Pasien</h5>
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
<div class="modal fade" id="modalTindakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daftar Tindakan</h5>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama Tindakan</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td><button class="btn btn-danger btn-sm">Pilih</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>