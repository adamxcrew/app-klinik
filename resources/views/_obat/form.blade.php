<table class="table table-bordered">
    <tr>
        <td>Kode Obat</td>
        <td>{!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'A']) !!}</td>
    </tr>
    <tr>
        <td>Nama Obat</td>
        <td>{!! Form::text('nama_obat', null, ['class'=>'form-control','Placeholder'=>'A']) !!}</td>
    </tr>
    <tr>
        <td>Harga</td>
        <td>{!! Form::text('harga', null, ['class'=>'form-control','Placeholder'=>'A']) !!}</td>
    </tr>
    <tr>
        <td>Stock</td>
        <td>{!! Form::text('stock', null, ['class'=>'form-control','Placeholder'=>'A']) !!}</td>
    </tr>
    <tr>
        <td>Status</td>
        <td>{!! Form::select('status',[1=>'Aktif',0=>'Tidak Aktif'], null, ['class'=>'form-control']) !!}</td>
    </tr>
    <tr>
        <td>Satuan</td>
        <td>{!! Form::select('satuan_id',$satuan, null, ['class'=>'form-control']) !!}</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button type="submit" class="btn btn-danger">Simpan</button>
            <a href="{{ route('obat.index')}}" class="btn btn-danger">Kembali</a>
        </td>
    </tr>
</table>