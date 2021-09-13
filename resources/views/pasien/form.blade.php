
<div class="form-group">
    <label class="col-sm-2 control-label">Nomor Pendaftaran</label>
    <div class="col-sm-3">
        <input type="text" name="kode" value="{{generateKodePendaftaran()}}" class="form-control" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nomor KTP & Nama</label>
    <div class="col-sm-3">
        {!! Form::text('nomor_ktp', null, ['class'=>'form-control ktp','Placeholder'=>'Nomor KTP']) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::text('nama', null, ['class'=>'form-control','Placeholder'=>'Nama Pasien']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tempat, Tanggal Lahir</label>
    <div class="col-sm-3">
        {!! Form::text('tempat_lahir', null, ['class'=>'form-control','Placeholder'=>'Tempat Lahir']) !!}
    </div>
    <div class="col-sm-2">
        {!! Form::date('tanggal_lahir', null, ['class'=>'form-control tanggal_lahir','Placeholder'=>'Tanggal Lahir']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nomor HP & Pekerjaan</label>
    <div class="col-sm-3">
        {!! Form::text('nomor_hp', null, ['class'=>'form-control','Placeholder'=>'Nomor HP']) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::text('pekerjaan', null, ['class'=>'form-control','Placeholder'=>'Pekerjaan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Alamat</label>
    <div class="col-sm-3">
        {!! Form::text('rt_rw', null, ['class'=>'form-control','Placeholder'=>'RT RW']) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::text('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
    </div>
</div>
<hr>
<div class="form-group">
    <label class="col-sm-2 control-label">Tujuan</label>
    <div class="col-sm-3">
        {!! Form::select('poliklinik_id',$poliklinik, null, ['class'=>'form-control poliklinik']) !!}
    </div>
    <div class="col-sm-4">
        <div id="dokter"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Layanan</label>
    <div class="col-sm-3">
        <input type="radio" name="jenis_layanan" value="umum"> Umum 
        <input type="radio" name="jenis_layanan" value="pbjs"> PBJS 
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/pasien" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>


@push('scripts')
<script>
$( document ).ready(function() {

    $(".ktp").keyup(function() {
        var ktp = $(".ktp").val();
        if(ktp.length>=16)
        {
            var tanggal_lahir = ktp.substr(6, 2);
            var bulan_lahir   = ktp.substr(8, 2);
            var tahun_lahir   = '19' + ktp.substr(10, 2);
            $(".tanggal_lahir").val(tahun_lahir+'-'+bulan_lahir+'-'+tanggal_lahir);
        }
        
    });
    

    $('.poliklinik').bind('change', function () {
        var poliklinik = $(".poliklinik").val();
        $.ajax({
            url: "/ajax/dropdown-dokter-berdasarkan-poliklinik",
            type: "get",
            data: {poliklinik:poliklinik},
            success: function(response) {
                $("#dokter").html(response);
        }});
    });

    $('.poliklinik').trigger('change');
});
</script>
@endpush