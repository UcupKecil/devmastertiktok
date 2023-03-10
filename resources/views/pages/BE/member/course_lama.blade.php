@extends('layouts.FE.page')
@section('content')
    <section class="page-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="banner-content text-center">
                        <h1>Course</h1>
                        <p>
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                            <span> > </span>
                            Course
                            <span> > </span>
                            {{ $title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="course-archive">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 border">
               
                
                    <div id="video">
                        <video style="width: 100%;
                            height: auto;" width="400" height="400" controls
                            poster="">
                            <source src="{{ asset('/assets/videos/courses/' . $course->id . '/' . $onDisplay->video) }}">
                        </video>
                      
                    </div>
                </div>
                <div class="col-12 border" >
                    @foreach ($videos as $video)
                        <div class="card video-card my-2 border {{ $video->id == $valid->last_video ? 'bg-warning' : '' }}"
                            style="cursor: pointer !important;" data-id="{{ $video->id }}">
                            <div class="card-body" style="cursor: pointer !important;">
                                <div class="row mt-1">
                                    <div class="col-10">
                                        <p>{{ $video->name }}</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    @include($js)
@endpush