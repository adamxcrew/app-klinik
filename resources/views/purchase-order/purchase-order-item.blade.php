<table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Kode Barang</th>
        <th scope="col">Nama Barang</th>
        <th scope="col">Jumlah</th>
        <th scope="col">Harga</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; ?>
      @foreach($purchase_order_detail as $row)
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $row->barang->kode }}</td>
        <td>{{ $row->barang->nama_barang }}</td>
        <td>{{ $row->qty }}</td>
        <td>@currency($row->barang->harga)</td>
        <td>
            <button class="btn btn-danger btn-sm" onClick="hapus_barang({{ $row->id }})">
              <i class="fa fa-trash"></i>
            </button>
        </td>
      </tr>
      <?php $total += $row->barang->harga * $row->qty;?>
      @endforeach
      <tr>
        <td></td>
        <td colspan="3">Total</td>
        <td colspan="2">@currency($total)</td>
      </tr>
    </tbody>
  </table>