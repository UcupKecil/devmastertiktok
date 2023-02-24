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
                        <video width="1000" height="400" controls
                            poster="{{ asset('/assets/images/courses/video/poster/' . $course->id . '/' . $onDisplay->poster) }}">
                            <source src="{{ asset('/assets/videos/courses/' . $course->id . '/' . $onDisplay->video) }}">
                        </video>
                        <hr>
                        {!! $onDisplay->detail !!}
                    </div>
                </div>
                <div class="col-12 border">
                    <div id="accordion">
                        <div class="card border">
                            {{-- <div class="card-header two active">
                                <a class="card-link" data-toggle="collapse" href="#collapseOne" aria-expanded="true">Link
                                    Referral
                                    Saya</a>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body current">
                                    p
                                </div>
                            </div> --}}
                            @foreach ($sections as $section)
                                <div
                                    class="card-header two border bg-success {{ isVideoOnDisplay($valid->last_video, $section->id, $course->id) ? 'active' : '' }}">
                                    <a class="card-link" data-toggle="collapse" href="#collapse{{ $section->id }}"
                                        aria-expanded="true">{{ $section->name }}</a>
                                </div>
                                <div id="collapse{{ $section->id }}"
                                    class="collapse {{ isVideoOnDisplay($valid->last_video, $section->id, $course->id) ? 'show' : '' }}"
                                    data-parent="#accordion" style="background: #fde5e5">
                                    <div class="card-body current">
                                        @php
                                            $videos = getVideoList($section->id, $course->id);
                                        @endphp
                                        @foreach ($videos as $video)
                                            <div class="card video-card my-2 border {{ $video->id == $valid->last_video ? 'bg-warning' : '' }}"
                                                style="cursor: pointer !important;" data-id="{{ $video->id }}">
                                                <div class="card-body" style="cursor: pointer !important;">
                                                    <div class="row mt-1">
                                                        <div class="col-9">
                                                            <p>{{ $video->name }}</p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p>{{ $video->duration }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    @include($js)
@endpush
