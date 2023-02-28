@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp
<!-- start header-top-area -->
<header class="header-area">
    <div class="header-top-area">
        <div class="container">
            <div class="header-top-wrap">
                <!--start couser search-->
                <div class="header-course-search">
                    <input type="text" placeholder="Search Courses" class="form-control">
                    <span><i class="fa fa-search"></i></span>
                </div>
                <!--end couser search-->
                <!--start header contact info-->
                <div class="header-contact-info text-right">
                    <ul>
                        <li><i class="fa fa-envelope"></i> {{$setting->email}}</li>
                        <li><i class="fa fa-phone"></i> {{$setting->hp}}</li>
                    </ul>
                </div>
                <!--end header contact info-->
                
            </div>
        </div>
    </div>
    <!--end header-top-area-->
    <!--start header-btm-area-->
    <div class="header-btm-area">
        <div class="container">
            <div class="main-menu-wrap">
                <div class="site-logo">
                    <a class="logo" href="{{ url('/') }}">
                        <img src="{{ asset('/assets/images/settings/' . $setting->image) }}" alt="logo">
                    </a>
                </div>

                <div class="main-menu-area text-left">
                    <nav class="mainmenu">
                        <ul>
                            <li>
                                <a class="{{ $segment1 == '' ? ' active' : '' }}" href="{{ url('/') }}">Home</a>
                            </li>
                            
                            @auth
                                <li><small>|</small></li>
                                <li>
                                    <a class="{{ $segment1 == 'dashboard' ? ' active' : '' }}"
                                        href="{{ url('/dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                @if (Auth::user()->getRoleNames()[0] == 'Admin')
                                    @include('components.layouts.FE.index.navbar.admin')
                                @endif
                            @endauth
                        </ul>
                    </nav>
                </div>

                <div class="header-log-reg text-right">
                    @auth
                        <ul>
                            <li><a href="/">{{ Auth::user()->name }}</a></li>
                            <li><small>|</small></li>
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    @endauth
                    @guest
                        <ul>
                            <li><a href="{{ url('/auth/login') }}">Login</a></li>
                        </ul>
                    @endguest
                </div>

                <div class="header-toggle-btn">
                    <a class="sidebar-toggle-btn">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</header>
