@extends('layouts.app')

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Data {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permintaan.index') }}">{{ $title }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Form Tambah {{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Form Tambah Data {{ $title }}
                </h6>
                <div class="card-body">
                    @include('include.flash')
                    <form class="form form-horizontal" action="{{ route('permintaan.keranjang.store') }}" method="POST">
                        <div class="form-body">
                            @csrf
                            @foreach ($forms as $key => $value)
                                <div class="row">
                                    <div class="col-md-3 text-sm-start text-md-end pt-2">
                                        <label>{{ $value[0] }}</label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        {{ $value[1] }}
                                        @error($key)
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                            <div class="offset-md-3 ps-2">
                                <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                                <a href="{{ route('permintaan.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <h6 class="card-header">
                    Keranjang Permintaan
                </h6>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>

                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($keranjang)
                                @for ($i = 0; $i < count($keranjang); $i++)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $keranjang[$i]['nama_barang'] }}</td>
                                        <td>{{ $keranjang[$i]['permintaan'] }}</td>
                                        <td>
                                            <a href="{{ route('permintaan.hapus_keranjang.store', $keranjang[$i]['id_barang_gudang']) }}" class="btn btn-sm btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                @endfor
                            @endif


                        </tbody>
                    </table>
                    @if ($keranjang)
                        <form action="{{ route('permintaan.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Simpan Pesanan</button>
                        </form>
                    @endif
                </div>
            </div>

        </section>
    </div>
@endsection
