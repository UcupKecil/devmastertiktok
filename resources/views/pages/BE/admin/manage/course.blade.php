@extends('layouts.FE.page')
@push('style')
    @include('components.styles.CDN.dataTables')
    @include('components.styles.CDN.font-awesome')
    @include('components.styles.CDN.lightbox2')
@endpush
@section('content')
    <section class="page-banner-area" style="background-image: url({{ asset('/assets/images/settings/' . $setting->imagebanner) }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="banner-content text-center">
                        <h1>{{ $title }}</h1>
                        <p>
                            Manage<span> > </span>{{ $title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="course-archive">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    @error('error')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @enderror
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @include('components.buttons.action.redirecttoFormButton')
                    <table id="table" class="table table-striped table-hover w-100 display nowrap">
                        <thead>
                            <th width="5%">#</th>
                            <th>name</th>
                            <th width="10%">cover</th>
                            <th width="5%">action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    @include('components.scripts.CDN.dataTables')
    @include('components.scripts.CDN.font-awesome')
    @include('components.scripts.CDN.lightbox2')
    @include('components.scripts.CDN.sweetalert2')
    @include($js)
@endpush
