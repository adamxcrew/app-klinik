<div class="form-group">
    <label class="col-sm-2 control-label">Nama Dokter</label>
    <div class="col-sm-10">
        {!! Form::hidden('user_id', $user->id) !!}
        {!! Form::text('', $user->name, ['class'=>'form-control', 'readonly']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Hari</label>
    <div class="col-sm-10">
        {!! Form::select('hari', $hari, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jam</label>
    <div class="col-sm-10">
        {!! Form::text('jam', null, ['class'=>'form-control','Placeholder'=>'Cth. 09:00 - 16:00']) !!}
    </div>
</div>

@if(Request::segment(3) == 'edit')
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/user/{{$user->id}}" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>
@endif