@extends('layouts.FE.page')
@section('content')
    <section class="page-banner-area" style="background-image: url({{ asset('/assets/images/settings/' . $setting->imagebanner) }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="banner-content text-center">
                        <h1>Login</h1>
                        <p>
                            <a href="{{ url('/') }}">Home</a>
                            <span> > </span>Member Login
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form action="{{ url('/auth/login') }}" method="post" id="form">
        @csrf
        <section class="login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 login-form-wrap">
                        <h3>Hi, Welcome back!</h3>
                        @error('error')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @enderror
                        <div class="form-group">
                            <input type="email" placeholder="Email Address" class="form-control" name="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Password" class="form-control" name="password" required>
                            @error('password')
                                <div class="text-danger" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="signed">Keep me signed in</label>
                            </div>
                            <div class="forgot-pass">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="login-btn text-center">
                            <a href="javascript:void(0)" onclick='document.getElementById("form").submit();''>Sign In</a>
                        </div>
                        <div class="new-registration text-center">
                            <span>Don't have an account?</span>
                            <a href="#">Registration Now </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
<!--end footer-->
