<table class="table table-bordered" id="ajax-po-item">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Kode Barang</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Harga (PO)</th>
            {{-- @if(!in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan'])) --}}
                <th scope="col">Action</th>
            {{-- @endif --}}
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
                {{-- @if(in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan']))
                    {{ $row->qty }}
                @else
                    <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'qty'>
                        {{ $row->qty }}
                    </a>
                @endif --}}
                {{ $row->qty }}
            </td>
            <td>
                {{-- @if(in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan']))
                        @currency($row->harga)
                @else
                    <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'harga'>
                        @currency($row->harga)
                    </a>
                @endif --}}
                @currency($row->harga)
            </td>
            {{-- @if(!in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan'])) --}}
            <td>
                <button class="btn btn-danger btn-sm" onClick="hapus_barang({{ $row->id }})">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
            {{-- @endif --}}
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