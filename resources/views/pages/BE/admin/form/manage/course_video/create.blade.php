@extends('layouts.FE.page')
@push('style')
    @include('components.styles.CDN.dropify')
    @include('components.styles.CDN.font-awesome')
    @include('components.styles.CDN.summernote')
@endpush
@section('content')
    <section class="page-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="banner-content text-center">
                        <h1>{{ $title }} {{ $course }}</h1>
                        <p>
                            Manage
                            <span> > </span>
                            <a href="{{ url('/manage/course') }}">Course</a>
                            <span> > </span>
                            {{ $title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="course-archive">
        <form action="{{ url('/manage/course/videos/' . $slug) }}" method="post" id="form" autocomplete="false"
            enctype="multipart/form-data">
            <input type="text" name="seconds" id="seconds">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 login-form-wrap">
                        @error('error')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @include('components.buttons.action.returnButton')
                        <div class="form-group">
                            <label for="name">Judul Materi</label>
                            <input type="text" placeholder="Judul Materi" class="form-control" name="name"
                                value="{{ old('name') }}" id="name" autocomplete="false" required>
                            @error('name')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="video">Video Materi</label>
                            <input type="file" class="form-control-file" name="video" id="video" required
                                onchange="getDuration(event)">
                            <small>*Mohon upload video berekstensi mp4 / mkv</small>
                            @error('video')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="detail">Keterangan</label>
                            <textarea name="detail" id="detail" class="form-control" required></textarea>
                            @error('detail')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="poster">Poster</label>
                            <input type="file" class="form-control-file" name="poster" id="poster"
                                autocomplete="false" data-max-file-size="1M" data-allowed-file-extensions="jpg png jpeg"
                                required>
                            @error('poster')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="login-btn text-center">
                            <a href="javascript:void(0)" onclick='document.getElementById("form").submit();''>Submit</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@push('script')
    @include('components.scripts.CDN.dropify')
    @include('components.scripts.CDN.summernote')
    @include($js)
@endpush
