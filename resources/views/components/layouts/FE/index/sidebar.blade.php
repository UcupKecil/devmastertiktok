<div class="sidebar-wrap">
    <div class="sidebar-inner">
        <div class="sidebar-close">
            <div class="sidebar-close-btn">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <div class="sidebar-content">
            <div class="sidebar-logo">
                <a href="{{ url('/') }}">
                    <img class="img-fluid" src="{{ asset('/assets/images/settings/' . $setting->image) }}"
                        alt="logo.png">
                </a>
            </div>
            <div class="mobile-menu"></div>
            <div class="search-form">
                <input type="text" placeholder="Search Courses" class="form-control">
                <span><i class="fa fa-search"></i></span>
            </div>
            <div class="contact-info">
                <ul>
                    <li><i class="fa fa-envelope"></i> {{$setting->email}}</li>
                    <li><i class="fa fa-phone"></i> {{$setting->hp}}</li>
                </ul>
            </div>
            <div class="social-icon">
                <ul>
                    <li><span>Follow Us:</span></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                </ul>
            </div>
            <div class="header-log-reg">
            @auth
                        <ul>
                            <li><a href="{{ url('/profil') }}">{{ Auth::user()->name }}</a></li>
                            <li><small>|</small></li>
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
            @endauth
            @guest
                <ul>
                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                    <li><small>|</small></li>
                    
                </ul>
            @endguest
            </div>
        </div>
    </div>
</div>
