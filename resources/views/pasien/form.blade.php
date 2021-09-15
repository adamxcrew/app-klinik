<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor Pendaftaran</label>
            <input type="text" name="kode" value="{{generateKodePendaftaran()}}" class="form-control" readonly>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor Rekam Medis</label>
            <input type="text" name="nomor_rekam_medis" value="{{generateKodeRekamMedis()}}" class="form-control" readonly>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor KTP</label>
            {!! Form::text('nomor_ktp', null, ['class'=>'form-control ktp','Placeholder'=>'Nomor KTP']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama pasien</label>
            {!! Form::text('nama', null, ['class'=>'form-control','Placeholder'=>'Nama Pasien']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Tempat Lahir</label>
            {!! Form::text('tempat_lahir', null, ['class'=>'form-control','Placeholder'=>'Tempat Lahir']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Tanggal Lahir</label>
            {!! Form::date('tanggal_lahir', null, ['class'=>'form-control tanggal_lahir','Placeholder'=>'Tanggal Lahir']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor HP</label>
            {!! Form::number('nomor_hp', null, ['class'=>'form-control','Placeholder'=>'Nomor HP']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Pekerjaan</label>
            {!! Form::text('pekerjaan', null, ['class'=>'form-control','Placeholder'=>'Pekerjaan']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Alamat</label>
            {!! Form::text('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>RT / RW</label>
            {!! Form::text('rt_rw', null, ['class'=>'form-control','Placeholder'=>'RT RW']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Pendidikan</label>
            {!! Form::select('pendidikan', $jenjang_pendidikan, null, ['class'=>'form-control','Placeholder'=>'Pendidikan']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Agama</label>
            {!! Form::select('agama', $agama, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <div >
                {{Form::radio('jenis_kelamin','pria',['class'=>'form-check-input'])}}
                <label>Pria</label>
                {{Form::radio('jenis_kelamin','wanita',['class'=>'form-check-input'])}}
                <label>Wanita</label>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Status Pernikahan</label>
            {!! Form::select('status_pernikahan', $status_pernikahan, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Kewarganegaraan</label>
            {!! Form::select('kewarganegaraan', $kewarganegaraan, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Suku Bangsa</label>
            {!! Form::text('suku_bangsa', null, ['class'=>'form-control','Placeholder'=>'Suku bangsa']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Golongan Darah</label>
            {!! Form::select('golongan_darah', $golongan_darah, null, ['class'=>'form-control','Placeholder'=>'Pendidikan']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Privilage Khusus</label>
            {!! Form::select('privilage_khusus', $privilage_khusus, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Provinsi</label>
            {!! Form::select('', $provinces, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Kota/Kab</label>
            {!! Form::select('', $provinces, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Kecamatan</label>
            {!! Form::select('', $provinces, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Desa/Kelurahan</label>
            {!! Form::select('', $provinces, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama Ibu Kandung</label>
            {!! Form::text('nama_ibu', null, ['class'=>'form-control','Placeholder'=>'Nama ibu kandung']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Penanggung Jawab</label>
            {!! Form::text('penanggung_jawab', null, ['class'=>'form-control','Placeholder'=>'Nama penanggung jawab']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Hubungan Dengan Pasien</label>
            {!! Form::select('hubungan_pasien', $hubungan_pasien, null, ['class'=>'form-control','Placeholder'=>'Pendidikan']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Alamat Penanggung Jawab</label>
            {!! Form::text('alamat_penanggung_jawab', null, ['class'=>'form-control','Placeholder'=>'Alamat penanggung jawab']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>No. Telepon Penanggung Jawab</label>
            {!! Form::text('no_telp_penanggung_jawab', null, ['class'=>'form-control','Placeholder'=>'Nomor telepon penanggung jawab']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Penjamin</label>
            {!! Form::select('penjamin', $penjamin, null, ['class'=>'form-control','Placeholder'=>'Pendidikan']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor Asuransi</label>
            {!! Form::text('nomor_asuransi', null, ['class'=>'form-control','Placeholder'=>'Nomor asuransi']) !!}
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-sm-2 control-label">Tujuan</label>
            <div class="col-sm-3">
                {!! Form::select('poliklinik_id',$poliklinik, null, ['class'=>'form-control poliklinik']) !!}
            </div>
            <div class="col-sm-4">
                <div id="dokter"></div>
            </div>
        </div>
    </div>
</div>
    <div class="form-group"></div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group mt-4">
            <label class="col-sm-2 control-label">Jenis Layanan</label>
            <div class="col-sm-4">
                {{Form::radio('jenis_layanan','umum',['class'=>'form-check-input'])}}
                <label class="form-check-label ml-2" for="inlineRadio1">Umum</label>
                {{Form::radio('jenis_layanan','bpjs',['class'=>'form-check-input'])}}
                <label class="form-check-label ml-2" for="inlineRadio2">BPJS</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group"></div>

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