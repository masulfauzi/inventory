@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <a href="{{ route('permintaan.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i
                            class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permintaan.index') }}">{{ $title }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $permintaan->nama }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Data {{ $title }}: {{ $permintaan->nama }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-2">
                            <div class="row">
                                <div class='col-lg-2'>
                                    <p>Status</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $permintaan->status->status_permintaan }}</p>
                                </div>
                                <div class='col-lg-2'>
                                    <p>User</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $permintaan->users->name }}</p>
                                </div>
                                <div class='col-lg-2'>
                                    <p>Tanggal Pengajuan</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ \App\Helpers\Format::tanggal($permintaan->created_at, false, false) }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Data {{ $title }}: {{ $permintaan->nama }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <form action="{{ route('permintaan.setujui.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_permintaan" value="{{ $permintaan->id }}">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Permintaan</th>
                                                <th>Jumlah Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($barang_permintaan as $item)
                                            <input type="hidden" name="id_barang_permintaan[]" value="{{ $item->id }}">
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->barangGudang->barang->nama_barang }}</td>
                                                    <td>{{ $item->permintaan }}</td>
                                                    <td>{{ $item->stok }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection