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
                            <a href="{{ url('/manage/setting') }}">Setting</a>
                            <span> > </span>
                            {{ $title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="setting-archive">
        <form action="{{ url('/manage/setting/' . $id) }}" method="post" id="form" autocomplete="false"
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
                            <input type="text" class="form-control" name="name" value="{{ $setting->name }}"
                                id="name" autocomplete="false" required>
                            @error('name')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email"
                                value="{{ ($setting->email) }}" id="email" autocomplete="false" required>
                            @error('email')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hp">Hp</label>
                            <input type="text" class="form-control" name="hp"
                                value="{{ ($setting->hp) }}" id="hp" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="detail">Keterangan</label>
                            <textarea name="detail" id="detail" class="form-control" required>{{ $setting->detail }}</textarea>
                            @error('detail')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Logo</label>
                            <input type="file" placeholder="Harga Kelas" class="form-control-file" name="image"
                                id="image" autocomplete="false" data-max-file-size="1M"
                                data-allowed-file-extensions="jpg png jpeg" required
                                data-default-file="{{ asset('/assets/images/settings/' . $setting->image) }}">
                            @error('image')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="imagebanner">Gambar Banner</label>
                            <input type="file" placeholder="Banner" class="form-control-file" name="imagebanner"
                                id="imagebanner" autocomplete="false" data-max-file-size="2M"
                                data-allowed-file-extensions="jpg png jpeg" required
                                data-default-file="{{ asset('/assets/images/settings/' . $setting->imagebanner) }}">
                            @error('imagebanner')
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
