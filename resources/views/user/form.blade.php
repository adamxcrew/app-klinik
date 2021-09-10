<div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Nama</label>

    <div class="col-sm-10">
        {!! Form::text('name', null, ['class'=>'form-control','Placeholder'=>'Nama Pengguna']) !!}
    </div>
</div>
<div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

    <div class="col-sm-10">
        {!! Form::email('email', null, ['class'=>'form-control','Placeholder'=>'Email']) !!}
    </div>
</div>
<div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Password</label>

    <div class="col-sm-10">
        {!! Form::password('password', ['class'=>'form-control','Placeholder'=>'Password']) !!}
    </div>
</div>
<div class="form-group">
    <label for="inputName" class="col-sm-2 control-label">Role Pengguna</label>

    <div class="col-sm-10">
        {!! Form::select('role',['administrator'=>'Administrator','dokter'=>'Dokter'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
    </div>
    <a href="/user" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
</div>