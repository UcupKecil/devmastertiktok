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
    
   
@endsection
@push('script')
    @include('components.scripts.CDN.dataTables')
    @include($js)
@endpush