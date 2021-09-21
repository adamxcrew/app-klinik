<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $barang)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$barang->kode}}</td>
            <td>{{$barang->nama_barang}}</td>
            <td>{{$barang->satuan->satuan}}</td>
        </tr>
        @endforeach
    </tbody>
</table>