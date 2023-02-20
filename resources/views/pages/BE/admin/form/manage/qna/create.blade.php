@extends('layouts.FE.page')
@push('style')
    @include('components.styles.CDN.dropify')
    @include('components.styles.CDN.font-awesome')
    @include('components.styles.CDN.summernote')
@endpush
@section('content')
    <section class="page-banner-area" style="background-image: url({{ asset('/assets/images/settings/' . $setting->imagebanner) }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="banner-content text-center">
                        <h1>{{ $title }}</h1>
                        <p>
                            Manage
                            <span> > </span>
                            <a href="{{ url('/manage/qna') }}">QNA</a>
                            <span> > </span>
                            {{ $title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="qna-archive">
        <form action="{{ url('/manage/qna') }}" method="post" id="form" autocomplete="false"
            enctype="multipart/form-data">
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
                            <label for="name">Judul QNA</label>
                            <input type="text" placeholder="Judul QNA" class="form-control" name="name"
                                value="{{ old('name') }}" id="name" autocomplete="false" required>
                            @error('name')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="detail_pertanyaan">Pertanyaan</label>
                            <textarea name="detail_pertanyaan" id="detail_pertanyaan" class="form-control" required></textarea>
                            @error('detail_pertanyaan')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="detail_jawaban">Jawaban</label>
                            <textarea name="detail_jawaban" id="detail_jawaban" class="form-control" required></textarea>
                            @error('detail_jawaban')
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
