<table class="table table-bordered">
    <tr>
        <th colspan="2">TEXT</th>
    </tr>
    <tr>
        <td>Tanggal Kunjungan</td>
        <td>{{ $pendaftaran->created_at }}</td>
    </tr>
    @foreach ($pendaftaran->nomorAntrian as $nomorAntrian)
    <tr>
        <td>Poliklinik</td>
        <td>{{ $nomorAntrian->poliklinik->nama }} | {{ $nomorAntrian->dokter->name }}</td>
    </tr>
    @endforeach
    <tr>
        <td>Anamnesa</td>
        <td>{{ $pendaftaran->anamnesa }}</td>
    </tr>
</table>


<h4>Tanda Tanda Vital</h4>
<table class="table table-bordered">
  <tr>
    <td>Berat Badan</td>
    <td>{{ $pendaftaran->tanda_tanda_vital }}</td>
  </tr>
  <tr>
    <td>Tekanan Darah</td>
    <td id="tekanan_darah"></td>
  </tr>
  <tr>
    <td>Suhu Tubuh</td>
    <td id="suhu_tubuh"></td>
  </tr>
  <tr>
    <td>Tinggi Badan</td>
    <td id="tinggi_badan"></td>
  </tr>
  <tr>
    <td>Nadi</td>
    <td id="nadi"></td>
  </tr>
  <tr>
    <td>RR</td>
    <td id="rr"></td>
  </tr>
  <tr>
    <td>Saturasi O2</td>
    <td id="saturasi_o2"></td>
  </tr>
  <tr>
    <td>Fungsi Penciuman</td>
    <td id="fungsi_penciuman"></td>
  </tr>
  <tr>
    <td>Status Alergi</td>
    <td id="status_alergi"></td>
  </tr>
  <tr>
    <td>Anamnesa</td>
    <td id="anamnesa"></td>
  </tr>
</table>

<h4>Riwayat Tindakan</h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Kode ICD 9</th>
      <th>Nama Tindakan</th>
    </tr>
  </thead>
  <tbody>
      @foreach($tindakan as $row)
          <tr>
              <td>{{ $row }}</td>
              <td>{{ $row }}</td>
          </tr>
      @endforeach
  </tbody>
</table>

<h4>Riwayat Diagnosa</h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Kode ICD</th>
      <th>Nama Diagnosa</th>
    </tr>
  </thead>
  <tbody id="riwayat-diagnosa">
  </tbody>
</table>

<h4>Riwayat Pemberian Obat</h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Nama Obat</th>
      <th>Jumlah</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody id="riwayat-obat">
  </tbody>
</table>