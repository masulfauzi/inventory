@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('baranggudang.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('baranggudang.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $baranggudang->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $baranggudang->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Barang</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $baranggudang->barang->nama_barang }}</p></div>
									<div class='col-lg-2'><p>Gudang</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $baranggudang->gudang->nama_gudang }}</p></div>
									<div class='col-lg-2'><p>Stok</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $baranggudang->stok }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Tabel Data {{ $title }}
            </h6>
            <div class="card-body">
                {{-- <div class="row">
                    <div class="col-9">
                        <form action="{{ route('transaksi.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						{!! button('transaksi.create', $title) !!}  
                    </div>
                </div> --}}
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>Barang Gudang</td>
								<td>Masuk</td>
								<td>Keluar</td>
								<td>Tgl Transaksi</td>
								{{-- <td>Bukti Transaksi</td> --}}
								
                                {{-- <th width="20%">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $transaksi->firstItem(); @endphp
                            @forelse ($transaksi as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->barangGudang->barang->nama_barang }}</td>
									<td>{{ $item->masuk }}</td>
									<td>{{ $item->keluar }}</td>
									<td>{{ $item->tgl_transaksi }}</td>
									{{-- <td>{{ $item->bukti_transaksi }}</td> --}}
									
                                    {{-- <td>
										{!! button('transaksi.show','', $item->id) !!}
										{!! button('transaksi.edit', $title, $item->id) !!}
                                        {!! button('transaksi.destroy', $title, $item->id) !!}
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center"><i>No data.</i></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
				{{ $transaksi->links() }}
            </div>
        </div>

    </section>
    
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection