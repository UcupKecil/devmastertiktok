<footer class="footer-area">
    <!--start footer top area-->
    <div class="footer-top-area" style="background: #000000;
    padding: 90px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);" >
        <div class="container">
            <div class="row">
                <!--start footer widget-->
                <div class="col-lg-8 col-md-6">
                    <div class="footer-widget logo" >
                        <a href="#"><img src="{{ asset('/assets/images/settings/' . $setting->image) }}"
                                alt="logo"></a>
                        <div class="footer-about-description">
                        <div style="word-wrap: break-word;">
                            {!! $setting->detail !!}
                        </div>
                        </div>
                        
                    </div>
                </div>
                <!--end footer widget-->
                
                
                <!--start footer widget-->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget recent-post">
                    <h4> Follow Kami</h4>
                        
                    <div class="d-flex flex-lg-row flex-md-row flex-sm-column flex-wrap">
                        <a target="_blank" href="https://web.facebook.com/Candradimuka-Jabar-Coding-Camp-101314435567102" class="col-lg-6 col-md-6 col-sm-12 d-flex flex-row text-decoration-none my-2 sosial">
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <img src="{{ asset('assets/img/facebook.svg') }}">
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-9" >
                                <p style="color:white;">Facebook</p>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.youtube.com/channel/UCV25phIpBTG77SKXbL0szEQ" class="col-lg-6 col-md-6 col-sm-12 d-flex flex-row text-decoration-none my-2 sosial">
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <img src="{{ asset('assets/img/youtube.svg') }}">
                            </div>
                            <div class="col-lg-10">
                                <p style="color:white;">YouTube</p>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.instagram.com/jabarcodingcamp/" class="col-lg-6 col-md-6 col-sm-12 d-flex flex-row text-decoration-none my-2 sosial">
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <img src="{{ asset('assets/img/instagram.svg') }}">
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-9">
                                <p style="color:white;">instagram</p>
                            </div>
                        </a>
                        <a target="_blank" href="https://vt.tiktok.com/ZGJk9hcUV/" class="col-lg-6 col-md-6 col-sm-12 d-flex flex-row text-decoration-none my-2 sosial">
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <img src="{{ asset('assets/img/TikTok.svg') }}">
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-9">
                                <p style="color:white;">Tiktok</p>
                            </div>
                        </a>
                    </div>
                    </div>
                    
                </div>

                <!--end footer widget-->
                <!--start footer widget-->
                
                
                <!--end footer widget-->
            </div>
        </div>
    </div>
    <!--end footer top area-->
    <!--start footer bottom-->
    <div class="footer-bottom-area text-center" style="background: #10c3c8;
    padding: 20px 0;" >
        <div class="container">
            <p class="m-0" style="color:black;">&copy; Copy 2023. MASTER TIKTOK AGENCY</p>
        </div>
    </div>
    <!--end footer bottom-->
</footer>
