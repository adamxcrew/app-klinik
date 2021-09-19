<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Barang</label>
    <div class="col-sm-5">
        {!! Form::select('jenis_barang',$jenis_barang, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kode Barang</label>
    <div class="col-sm-2">
        {!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'Kode Barang']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Nama Barang</label>
    <div class="col-sm-6">
        {!! Form::text('nama_barang', null, ['class'=>'form-control','Placeholder'=>'Nama Barang']) !!}
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-8">
        {!! Form::text('keterangan', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Satuan</label>
    <div class="col-sm-5">
        {!! Form::select('satuan_id',$satuan, null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Kategori</label>
    <div class="col-sm-5">
        {!! Form::select('kategori_id',$satuan, null, ['class'=>'form-control']) !!}
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Harga</label>
    <div class="col-sm-2">
        {!! Form::text('harga', null, ['class'=>'form-control','Placeholder'=>'Harga']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Stock</label>
    <div class="col-sm-2">
        {!! Form::text('stock', null, ['class'=>'form-control','Placeholder'=>'Stock']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Status</label>
    <div class="col-sm-2">
        {!! Form::select('aktif',[1=>'Aktif',0=>'Tidak Aktif'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/obat" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>