@extends('layouts.FE.page')
@push('style')
    @include('components.styles.CDN.dataTables')
@endpush
@section('content')
    <section class="page-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="banner-content text-center">
                        <h1>Dashboard</h1>
                        <p>
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="course-archive">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4>Histori Order</h4>
                    <table id="table" class="table table-striped table-hover w-100 display nowrap">
                        <thead>
                            <th width="5%">#</th>
                            <th>Waktu</th>
                            <th>Nama</th>
                            <th>Biaya Kelas</th>
                            <th>Biaya Admin</th>
                            <th>Total</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @foreach ($adminOrders as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>Rp. {{ number_format($row->sub_total) }}</td>
                                    <td>Rp. {{ number_format($row->biaya_adm) }}</td>
                                    <td>Rp. {{ number_format($row->total) }}</td>
                                    <td>{{ $row->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <section class="course-archive">
    </section>
@endsection
@push('script')
    @include('components.scripts.CDN.dataTables')
    @include($js)
@endpush