<div class="form-group">
    <label class="col-sm-2 control-label">Kode Tindakan</label>
    <div class="col-sm-4">
        {!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'Kode Tindakan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nama Tindakan</label>
    <div class="col-sm-10">
        {!! Form::text('tindakan', null, ['class'=>'form-control','Placeholder'=>'Nama Tindakan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Harga</label>
    <div class="col-sm-10">
        {!! Form::text('harga', null, ['class'=>'form-control','Placeholder'=>'Harga']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/obat" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>