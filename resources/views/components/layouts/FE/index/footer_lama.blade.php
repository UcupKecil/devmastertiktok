<footer class="footer-area">
    <!--start footer top area-->
    <div class="footer-top-area">
        <div class="container">
            <div class="row">
                <!--start footer widget-->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget logo">
                        <a href="#"><img src="{{ asset('/assets/images/settings/' . $setting->image) }}"
                                alt="logo"></a>
                        <div class="footer-about-description">
                        <div style="word-wrap: break-word;">
                            {!! $setting->detail !!}
                        </div>
                        </div>
                        <h6>Follow Us</h6>
                        <ul class="footer-social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!--end footer widget-->
                <!--start footer widget-->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget footer-cat">
                        <h4>Categories</h4>
                        <ul>
                            <li><a href="#"><i class="fa fa-angle-right"></i> Business</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i> Design</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i> Development</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i> Marketing</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i> Photography</a></li>
                        </ul>
                    </div>
                </div>
                <!--end footer widget-->
                <!--start footer widget-->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget recent-post">
                        <h4> Recent Posts</h4>
                        <!--start recent post single-->
                        <div class="footer-post-single">
                            <div class="recent-post-thumb">
                                <img src="{{ asset('assets/templates/omexo/assets/images/blog-sm-5.jpg') }}"
                                    alt="image" class="img-fluid">
                            </div>
                            <div class="recent-post-cont">
                                <h6><a href="#">Learn Webs Applications Development from Experts</a></h6>
                                <span>April 1, 2022</span>
                            </div>
                        </div>
                        <!--end recent post single-->
                        <!--start recent post single-->
                        <div class="footer-post-single m-0">
                            <div class="recent-post-thumb">
                                <img src="{{ asset('assets/templates/omexo/assets/images/blog-sm-5.jpg') }}"
                                    alt="image" class="img-fluid">
                            </div>
                            <div class="recent-post-cont">
                                <h6><a href="#">Expand Your Career Opportunities With Python</a></h6>
                                <span>May 25, 2022</span>
                            </div>
                        </div>
                        <!--end recent post single-->
                    </div>
                </div>
                <!--end footer widget-->
                <!--start footer widget-->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget footer-contact">
                        <h4>Contact Us</h4>
                        <ul>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <p class="m-0">250/A Oval Street, Mount View, London, United Kingdom</p>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <p class="m-0">support@example.com</p>
                            </li>
                            <li>
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <p class="m-0">+98 12345 67890</p>
                            </li>
                            <li class="p-0 info">Feel free to contact us
                            </li>
                        </ul>
                    </div>
                </div>
                <!--end footer widget-->
            </div>
        </div>
    </div>
    <!--end footer top area-->
    <!--start footer bottom-->
    <div class="footer-bottom-area text-center">
        <div class="container">
            <p class="m-0">&copy; Copy 2022. All Rights Reserved</p>
        </div>
    </div>
    <!--end footer bottom-->
</footer>
