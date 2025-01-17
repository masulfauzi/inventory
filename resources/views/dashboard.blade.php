@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Dashboard</h3>
                    <div class="d-flex align-items-center">
                        <form class="d-flex mx-3">
                            <input class="form-control me-2" type="search" placeholder="Cari sesuatu..." aria-label="Search">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </form>
                        <div class="ms-3">
                            <img src="/assets/images/Doorbell.png" alt="Notifikasi" class="rounded-circle" width="40">
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>


<div class="page-content">
    @include('include.flash')
    <section class="row">
        <div class="row mb-4">
            <div class="col-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ asset('assets/images/trolley.png') }}" alt="Data Barang" width="50">
                        </div>
                        <div>
                            <h6 class="text-muted">Data Barang</h6>
                            <h2>10</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ asset('assets/images/package.png') }}" alt="Barang Masuk" width="50">
                        </div>
                        <div>
                            <h6 class="text-muted">Barang Masuk</h6>
                            <h2>20</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <img src="{{ asset('assets/images/barang keluar.png') }}" alt="Barang Keluar" width="50">
                        </div>
                        <div>
                            <h6 class="text-muted">Barang Keluar</h6>
                            <h2>15</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Stok barang yang mencapai batas minimum</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>AB 1122</td>
                                <td>Lorem Ipsum</td>
                                <td>Lorem Ipsum</td>
                                <td>12</td>
                                <td>Lorem</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>AB 1123</td>
                                <td>Lorem Ipsum</td>
                                <td>Lorem Ipsum</td>
                                <td>11</td>
                                <td>Lorem</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>AB 1124</td>
                                <td>Lorem Ipsum</td>
                                <td>Lorem Ipsum</td>
                                <td>10</td>
                                <td>Lorem</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@section('page-js')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endsection