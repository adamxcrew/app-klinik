<tr class="komposisi-{{$komposisi_item}}">
    <td colspan="2">
      {{-- {{ Form::select('obat_id[][]',$barang,null,['class'=>'form-control barang','style'=>'width:100%'])}} --}}
      <select name="barang_id[{{$id}}][]" class='form-control barang_id_txt_{{$id}}' style="width:100%">
    </td>
    <td>
     
      <div class="row">
        <div class="col-md-5">
          {{ Form::text('jumlah['.$id.'][]',null,['class'=>'form-control','placeholder'=>'Jumlah'])}}
        </div>
        <div class="col-md-5">
          <button type="button" class="btn btn-sm btn-danger" onClick="hapus_komposisi({{$id}})">
            <i class="fa fa-trash" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </td>
  </tr>