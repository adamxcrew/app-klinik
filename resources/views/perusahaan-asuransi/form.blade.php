<div class="form-group">
    <label class="col-sm-2 control-label">Nama</label>
    <div class="col-sm-10">
        {!! Form::text('nama', null, ['class'=>'form-control','Placeholder'=>'Nama']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Alamat</label>
    <div class="col-sm-10">
        {!! Form::textarea('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">No. Telepon</label>
    <div class="col-sm-10">
        {!! Form::number('no_telp', null, ['class'=>'form-control','Placeholder'=>'No Telepon']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Contact Person</label>
    <div class="col-sm-10">
        {!! Form::text('contact_person', null, ['class'=>'form-control','Placeholder'=>'Contact Person']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">No. Telp CP</label>
    <div class="col-sm-10">
        {!! Form::number('no_telp_cp', null, ['class'=>'form-control','Placeholder'=>'No Telepon CP']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Lama Kontrak</label>
    <div class="col-sm-3">
        {!! Form::date('mulai_kontrak', null, ['class'=>'form-control']) !!}
    </div>

    <div class="col-sm-1 text-center" style="margin: 0 -30px">
        S/D
    </div>
    
    <div class="col-sm-3">
        {!! Form::date('akhir_kontrak', null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kelompok Perusahaan</label>
    <div class="col-sm-10">
        <div class="form-check form-check-inline">
            <div class="row col-sm-2">
                {{Form::radio('kelompok_perusahaan','bumn',['class'=>'form-check-input'])}}
                <label class="form-check-label ml-2" for="inlineRadio1">BUMN</label>
            </div>
            <div class="col-sm-2">
                {{Form::radio('kelompok_perusahaan','pemerintah',['class'=>'form-check-input'])}}
                <label class="form-check-label ml-2" for="inlineRadio2">Pemerintah</label>
            </div>
            <div class="col-sm-2">
                {{Form::radio('kelompok_perusahaan','swasta',['class'=>'form-check-input'])}}
                <label class="form-check-label ml-2" for="inlineRadio2">Swasta</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kelompok</label>
    <div class="col-sm-10">
        {!! Form::select('kelompok', ['umum' => 'Umum', 'non_umum' => 'Non Umum'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/asuransi" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>