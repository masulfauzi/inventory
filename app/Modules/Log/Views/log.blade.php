@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Data {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <form action="{{ route('log.index') }}" method="get">
                                <div class="form-group col-md-3 has-icon-left position-relative">
                                    <input type="text" class="form-control" value="{{ request()->get('search') }}"
                                        name="search" placeholder="Search">
                                    <div class="form-control-icon"><i class="fa fa-search"></i></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            {!! button('log.create', $title) !!}
                        </div>
                    </div>
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>User</td>
                                    <td>Aktivitas</td>
                                    <td>Route</td>
                                    <td>Action</td>
                                    <td>Context</td>
                                    <td>Data</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $data->firstItem(); @endphp
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->id_user }}</td>
                                        <td>{{ $item->aktivitas }}</td>
                                        <td>{{ $item->route }}</td>
                                        <td>{{ $item->action }}</td>
                                        <td>{{ $item->context }}</td>
                                        <td>{{ $item->data }}</td>

                                        <td>
                                            <a href="{{ route('log.show', $item->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('log.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('log.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center"><i>No data.</i></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $data->links() }}
                </div>
            </div>

        </section>
    </div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection
