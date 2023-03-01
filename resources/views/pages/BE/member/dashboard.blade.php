@extends('layouts.FE.page')
@push('style')
    @include('components.styles.CDN.dataTables')
    @include('components.styles.CDN.font-awesome')
    @include('components.styles.CDN.lightbox2')
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
        @if ($courses)
            <div class="container">
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-lg-4 col-md-6">
                            <div class="course-card">
                                <div class="course-thumbnail">
                                    <a href="{{ url('/mycourse/' . $course->slug) }}">
                                        <img src="{{ asset('assets/images/courses/' . $course->image) }}"
                                            class="img-fluid course-image" alt="{{ $course->name }}">
                                    </a>
                                </div>
                                <div class="course-content">
                                   
                                  
                                    <h3 class="course-title">
                                        <a href="{{ url('/mycourse/' . $course->slug) }}">{{ $course->name }}</a>
                                    </h3>
                                    
                                    <div class="course-content-footer">
                                        <ul>
                                        <div class="category-btn btn-default text-center">
                                                <a href="{{ url('/mycourse/' . $course->slug) }}">Masuk Kelas</a>
                                        </div>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        </section>
        @if (count($unpaidOrder) > 0)
        <section>
            <div class="container">
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
        </section>
        <section>
        <div class="container">
            <div id="accordion">
                <div class="card border">
                    <div class="card-header two">
                        <a class="card-link" data-toggle="collapse" href="#collapseOne" aria-expanded="true">Link Referral
                            Saya</a>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body current">

                            <!-- <a href="javascript:void(0)" onclick="copy()"
                                id="myReferral">{{ url('/member/aff/' . $user->uid) }}</a> -->

                                <input type="text" value="{{ url('/member/aff/' . $user->uid) }}" id="myInput">
                               
                                <button onclick="myFunction()">Copy text  <a  class="fas fa-copy"></a> </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        </section>
        <section>
        @if ($referralHistory)
        <div class="container" style="color:#000;">
        <h4>Histori Referral</h4>
                        <table id="table" class="table table-striped table-hover w-100 display nowrap">
                            <thead>
                                <th width="5%">#</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Point</th>
                            </thead>
                            @for ($i = 0; $i < count($referralHistory); $i++)
                            <tbody>
                               
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($referralHistory[$i]['date'])) }}</td>
                                    <td>
                                        {{ $referralHistory[$i]['name'] }}
                                    </td>
                                    <td>{{ number_format($referralHistory[$i]['point']) }}</td>
                              
                            </tbody>
                            @endfor
                        </table>
        </div>
        @endif
        </section>
        
       
@endsection
@push('script')
    @include('components.scripts.CDN.dataTables')
    @include('components.scripts.CDN.font-awesome')
    @include('components.scripts.CDN.lightbox2')
    @include('components.scripts.CDN.sweetalert2')
  
    @include($js)
@endpush
