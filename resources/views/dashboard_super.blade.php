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
                                <input class="form-control me-2" type="search" placeholder="Cari sesuatu..."
                                    aria-label="Search">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </form>
                            <div class="ms-3">
                                <img src="/assets/images/Doorbell.png" alt="Notifikasi" class="rounded-circle"
                                    width="40">
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
                <div class="col-3">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <img src="{{ asset('assets/images/trolley.png') }}" alt="Data Barang" width="50">
                            </div>
                            <div>
                                <h6 class="text-muted">Data Barang</h6>
                                <h2>{{ count($barang) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <img src="{{ asset('assets/images/package.png') }}" alt="Barang Masuk" width="50">
                            </div>
                            <div>
                                <h6 class="text-muted">Data Gudang</h6>
                                <h2>{{ count($gudang) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <img src="{{ asset('assets/images/barang keluar.png') }}" alt="Barang Keluar"
                                    width="50">
                            </div>
                            <div>
                                <h6 class="text-muted">Data User</h6>
                                <h2>{{ count($users) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <img src="{{ asset('assets/images/package.png') }}" alt="Barang Masuk" width="50">
                            </div>
                            <div>
                                <h6 class="text-muted">Data Permintaan</h6>
                                <h2>{{ count($permintaan) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Grafik Data Permintaan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Data Permintaan</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('page-js')
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach ($chart as $status)
                        
                    '{{ $status->status_permintaan }}',

                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah',
                    data: [@foreach ($chart as $status)
                        
                        '{{ $status->jumlah }}',
    
                        @endforeach],
                    // backgroundColor: [
                    //     'rgb(255, 99, 132)',
                    //     'rgb(54, 162, 235)',
                    //     'rgb(255, 205, 86)'
                    // ],
                    hoverOffset: 4
                }]
            }
        });
    </script>

    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endsection
