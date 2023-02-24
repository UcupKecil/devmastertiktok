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
                        <h1>{{ $title }}</h1>
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
        <form action="{{ url('/manage/course/' . $id) }}" method="post" id="form" autocomplete="false"
            enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 login-form-wrap">
                        @error('error')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                        @include('components.buttons.action.returnButton')
                        <div class="form-group">
                            <label for="name">Judul Kelas</label>
                            <input type="text" class="form-control" name="name" value="{{ $course->name }}"
                                id="name" autocomplete="false" required>
                            @error('name')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" placeholder="Judul Kelas" class="form-control" name="subtitle"
                                value="{{ $course->subtitle }}" id="subtitle" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="price">Harga Kelas</label>
                            <input type="text" class="form-control price" name="price"
                                value="{{ number_format($course->price) }}" id="price" autocomplete="false" required>
                            @error('price')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="crossed_price">Harga Coret</label>
                            <input type="text" class="form-control price" name="crossed_price"
                                value="{{ number_format($course->crossed_price) }}" id="crossed_price"
                                autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="detail">Keterangan</label>
                            <textarea name="detail" id="detail" class="form-control" required>{{ $course->detail }}</textarea>
                            @error('detail')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar</label>
                            <input type="file" placeholder="Harga Kelas" class="form-control-file" name="image"
                                id="image" autocomplete="false" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png jpeg" required
                                data-default-file="{{ asset('/assets/images/courses/' . $course->image) }}">
                            @error('image')
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
