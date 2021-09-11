
<div class="form-group">
    <label class="col-sm-2 control-label">Nomor Pendaftaran</label>
    <div class="col-sm-3">
        <input type="text" value="{{generateKodePendaftaran()}}" class="form-control" readonly>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nomor KTP & Nama</label>
    <div class="col-sm-3">
        {!! Form::text('nomor_ktp', null, ['class'=>'form-control','Placeholder'=>'Nomor KTP']) !!}
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
        {!! Form::date('tanggal_lahir', null, ['class'=>'form-control','Placeholder'=>'Tanggal Lahir']) !!}
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
        {!! Form::select('poliklinik',$poliklinik, null, ['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::text('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Layanan</label>
    <div class="col-sm-3">
        <input type="radio" name="layanan" value="umum"> Umum 
        <input type="radio" name="layanan" value="pbjs"> PBJS 
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/pasien" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>