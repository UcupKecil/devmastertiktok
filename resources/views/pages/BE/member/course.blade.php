@extends('layouts.FE.page')
@section('content')
    
    
    
    
    <section class="video-area text-center col-lg-10 offset-lg-1">
        <h1> KELAS </h1>
        <br>
        <br>
        <br>
        <br>
        <div class="container " style="max-width: 740px;" id="video">
          
                        <video  class="container" style="max-width: 740px;" controls
                        controlsList="nodownload" oncontextmenu="return false;"
                            >
                            <source src="{{ asset('/assets/videos/courses/' . $course->id . '/' . $onDisplay->video) }}"
                           >
                        </video>
                        <hr>
                        {!! $onDisplay->detail !!}
        


        </div>

                   
                
               
           
        
    </section>
    <section>
    <div class="row">
                <div class="col-12 border">
                    <div id="accordion">
                        <div class="card border">
                            
                            @foreach ($sections as $section)
                                <div
                                    class="card-header two border {{ isVideoOnDisplay($valid->last_video, $section->id, $course->id) ? 'active' : '' }}"
                                    style="background:#10C3C8">
                                    <a class="card-link" data-toggle="collapse" href="#collapse{{ $section->id }}"
                                        aria-expanded="true" style="color:#000">{{ $section->name }}</a>
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
</section>
@endsection
@push('script')
    @include($js)
    <!-- @include('components.scripts.CDN.disable-devtool') -->
@endpush
