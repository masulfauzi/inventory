<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Transaksi</title>
</head>
<body>
    <h1 style="text-align: center">Laporan Transaksi</h1>
    <br>
    <table class="table" border="1px" id="table1" style="width: 100%">
        <thead>
            <tr style="text-align: center">
                <th width="15">No</th>
                <td>Barang Gudang</td>
                <td>Masuk</td>
                <td>Keluar</td>
                <td>Tgl Transaksi</td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($laporan as $item)
                <tr style="height: 100px">
                    <td style="text-align: center">{{ $no++ }}</td>
                    <td style="text-align: center">{{ $item->barangGudang->barang->nama_barang }}</td>
                    <td style="text-align: center">{{ $item->masuk }}</td>
                    <td style="text-align: center">{{ $item->keluar }}</td>
                    <td style="text-align: center">{{ $item->tgl_transaksi }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center"><i>No data.</i></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>