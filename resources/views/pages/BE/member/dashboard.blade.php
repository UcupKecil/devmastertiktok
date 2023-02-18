@extends('layouts.FE.page')
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
        @if (count($unpaidOrder))
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h4>Menunggu pembayaran</h4>
                        <table id="table" class="table table-striped table-hover w-100 display nowrap">
                            <thead>
                                <th width="5%">#</th>
                                <th>Kelas</th>
                                <th>Total</th>
                                <th width="5%">action</th>
                            </thead>
                            <tbody>
                                @foreach ($unpaidOrder as $row)
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>Rp. {{ number_format($row->total) }}</td>
                                    <td>
                                        <a href="{{ url('/tripay/instruction/' . $row->reference) }}"
                                            class="btn btn-sm btn-primary my-3" target="_blank">
                                            Bayar
                                        </a>
                                    </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div id="accordion">
            <div class="card">
                <div class="card-header two">
                    <a class="card-link" data-toggle="collapse" href="#collapseOne" aria-expanded="true">Link Referral
                        Saya</a>
                </div>
                <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                    <div class="card-body current">
                        <a href="javascript:void(0)" onclick="copy()"
                            id="myReferral">{{ url('/member/aff/' . $user->uid) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    @include($js)
@endpush
