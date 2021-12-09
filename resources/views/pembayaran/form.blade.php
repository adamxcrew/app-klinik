<div class="form-group">
    <label class="col-sm-2 control-label">Jumlah Bayar</label>
    <div class="col-sm-5">
        <div class="input-group">
            <span class="input-group-addon">Rp</span>
            {!! Form::number('jumlah_bayar', null, ['class'=>'form-control','Placeholder'=>'Jumlah Pembayaran']) !!}
            <span class="input-group-addon">.00</span>
          </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Metode Pembayaran</label>
    <div class="col-sm-5">
        {!! Form::select('metode_pembayaran', array_merge(['' => '--PILIH METODE PEMBAYARAN--'] + $metodePembayaran) ,null, ['class'=>'form-control','Placeholder'=>'Nama Obat']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-success btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
        <a href="/pendaftaran" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>