@extends('layouts.FE.page')
@section('content')
    <section class="page-banner-area" style="background-image: url({{ asset('/assets/images/settings/' . $setting->imagebanner) }});">
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
    </section>
@endsection
@push('script')
    @include($js)
@endpush
