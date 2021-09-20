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
    <label class="col-sm-2 control-label">Poliklinik</label>
    <div class="col-sm-5">
        {!! Form::select('poliklinik_id',$poliklinik, null, ['class'=>'form-control','Placeholder'=>'Nama Tindakan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tarif</label>
    <div class="col-sm-3">
        {!! Form::text('umum', null, ['class'=>'form-control','Placeholder'=>'Tarif Umum']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::text('perusahaan', null, ['class'=>'form-control','Placeholder'=>'Tarif Perusahaan']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::text('bpjs', null, ['class'=>'form-control','Placeholder'=>'Trafi BPJS']) !!}
    </div>
</div>
<hr>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="row">
        @foreach($jenis as $j)
            <div class="col-md-3">
                @foreach($object as $row)
                <div class="form-group">
                    <label>Fee {{ $row }}</label>
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Enter ...">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Enter ...">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/obat" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>