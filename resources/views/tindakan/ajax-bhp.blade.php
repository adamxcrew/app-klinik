<table class="table table-bordered">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Kode Barang</th>
        <th scope="col">Nama Barang</th>
        <th scope="col">Jumlah Dipakai</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @php $jumlah=0 @endphp
        @forelse($listBhp as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->barang->kode}}</td>
                <td>{{$row->barang->nama_barang}}</td>
                <td style="text-align:right">{{$row->jumlah}}</td>
                <td>
                    <button class="btn btn-danger btn-hapus-barang" onClick="hapus_barang({{$row->id}})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @php 
            $jumlah+=$row->jumlah;
        @endphp
        @empty
            <tr>
                <td colspan=6 style="text-align:center">Data kosong</td>
            </tr>
        @endforelse
        <tr>
            <td style="text-align:right" colspan="3">Total</td>
            <td style="text-align:right"> {{$jumlah}} </td>
            <td></td>
        </tr>
    </tbody>
</table>

@push('scripts')

@endpush