<div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Nama</label>

    <div class="col-sm-5">
        {!! Form::text('name', null, ['class'=>'form-control','Placeholder'=>'Nama Pengguna']) !!}
    </div>
    @if($_GET['jabatan']!='user')
    <div class="col-sm-3">
        {!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'Kode']) !!}
    </div>
    @endif
</div>
<div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">Email & Password</label>

    <div class="col-sm-5">
        {!! Form::email('email', null, ['class'=>'form-control','Placeholder'=>'Email']) !!}
    </div>
    <div class="col-sm-5">
        {!! Form::password('password', ['class'=>'form-control','Placeholder'=>'Password']) !!}
    </div>
</div>

@if($_GET['jabatan']=='dokter')
<div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">Poliklinik & Spesialis</label>

    <div class="col-sm-5">
        {!! Form::select('poliklinik_id',$poliklinik, null, ['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-5">
        {!! Form::text('spesialis',null, ['class'=>'form-control','Placeholder'=>'Spesialis']) !!}
    </div>
</div>
@endif


<div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Jabatan</label>

    <div class="col-sm-10">
        {{-- {!! Form::hidden('role', $_GET['jabatan']) !!} --}}
        {!! Form::select('role',['administrator'=>'Administrator','dokter'=>'Dokter','kasir'=>'Kasir', 'keuangan' => 'Keuangan', 'hrd' => 'HRD'], $_GET['jabatan'], ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/user?jabatan={{$_GET['jabatan']}}" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>