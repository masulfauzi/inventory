<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
</head>
<body>
    <h1 style="text-align: center">Laporan Stok Barang</h1>
    <br>
        <table class="table" border="1px" id="table1" style="width: 100%">
            <thead>
                <tr>
                    <th width="15">No</th>
                    <td style="text-align: center">Barang</td>
                    <td style="text-align: center">Stok</td>
                    <td style="text-align: center">Gudang</td>
                </tr>
            </thead>
            <tbody>
                @php $no = $data->firstItem(); @endphp
                @forelse ($data as $item)
                    <tr style="height: 100px">
                        <td style="text-align: center">{{ $no++ }}</td>
                        <td style="text-align: center">{{ $item->barang->nama_barang }}</td>
                        <td style="text-align: center">{{ $item->stok }}</td>
                        <td style="text-align: center">{{ $item->gudang->nama_gudang }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center"><i>No data.</i></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</body>
</html>

