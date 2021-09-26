<div class="form-group">
    <label class="col-sm-2 control-label">Nama Pegawai</label>
    <div class="col-sm-10">
        {!! Form::text('nama', null, ['class'=>'form-control','Placeholder'=>'Nama']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">NIP Pegawai</label>
    <div class="col-sm-10">
        {!! Form::text('nip', null, ['class'=>'form-control','Placeholder'=>'NIP']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tempat, Tanggal Lahir</label>
    <div class="col-sm-4">
        {!! Form::text('tempat_lahir', null, ['class'=>'form-control','Placeholder'=>'Tempat lahir']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::date('tanggal_lahir', null, ['class'=>'form-control','Placeholder'=>'Nama']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kelompok pegawai</label>
    <div class="col-sm-10">
        {!! Form::select('kelompok_pegawai', $kelompok_pegawai,null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Agama</label>
    <div class="col-sm-10">
        {!! Form::select('agama', $agama, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Kelamin</label>
    <div class="col-sm-10">
        <div class="form-check form-check-inline">
            {{Form::radio('jenis_kelamin','pria',['class'=>'form-check-input'])}}
            <label class="form-check-label ml-2" for="inlineRadio1">Pria</label>
            {{Form::radio('jenis_kelamin','wanita',['class'=>'form-check-input'])}}
            <label class="form-check-label ml-2" for="inlineRadio2">Wanita</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Alamat</label>
    <div class="col-sm-10">
        {!! Form::text('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/pegawai" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>