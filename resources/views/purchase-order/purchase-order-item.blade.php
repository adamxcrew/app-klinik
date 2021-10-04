@php
    if(!isset($isApprove)){
        $isApprove = 0;
    }
@endphp

<table class="table table-bordered" id="ajax-po-item">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Kode Barang</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Harga (PO)</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0;  ?>
        @foreach($purchase_order_detail as $row)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $row->barang->kode }}</td>
            <td>{{ $row->barang->nama_barang }}</td>
            <td>
                <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'qty'>
                    {{ $row->qty }}
                </a>
            </td>
            <td>
                <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'harga'>
                    @currency($row->harga)
                </a>
            </td>
            <td>
                @if(!$isApprove)
                    <button class="btn btn-danger btn-sm" onClick="hapus_barang({{ $row->id }})">
                        <i class="fa fa-trash"></i>
                    </button>
                @endif
            </td>
        </tr>
        <?php $total += $row->harga * $row->qty;?>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td colspan="3">Total</td>
            <td colspan="2">@currency($total)</td>
        </tr>
    </tfoot>
</table>