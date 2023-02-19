@extends('layouts.FE.index')
@push('style')
    @include('components.styles.FE.index')
@endpush
@section('content')
    <!--start category area-->
    <section class="category-area">
        <div class="container">
            <div class="row">
                <!--start heading-->
                <div class="col-lg-6 offset-lg-3">
                    <div class="sec-heading text-center">
                        <h4>Testimoni Alumni Kelas</h4>
                    </div>
                </div>
                <!--end heading-->
            </div>
            <div class="row">
                <!--start category single -->
                <div class="col-md-3">
                    <div class="category-single text-center">
                        <a href="#"><img src="{{ asset('assets/templates/omexo/assets/images/cat-1.jpg') }}"
                                class="img-fluid" alt="image"></a>
                        <h4><a href="#">Development</a></h4>
                        <p>6 Courses</p>
                    </div>
                </div>
                <!--end category single -->
                <!--start category single -->
                <div class="col-md-3">
                    <div class="category-single text-center">
                        <div class="course-category-img">
                            <a href="#"><img src="{{ asset('assets/templates/omexo/assets/images/cat-1.jpg') }}"
                                    class="img-fluid" alt="image"></a>
                        </div>
                        <div class="category-cont text-center">
                            <h4><a href="#">Business</a></h4>
                            <p>8 Courses</p>
                        </div>
                    </div>
                </div>
                <!--end category single -->
                <!--start category single -->
                <div class="col-md-3">
                    <div class="category-single text-center">
                        <div class="course-category-img">
                            <a href="#"><img src="{{ asset('assets/templates/omexo/assets/images/cat-1.jpg') }}"
                                    class="img-fluid" alt="image"></a>
                        </div>
                        <div class="category-cont text-center">
                            <h4><a href="#">Heath & Fitness</a></h4>
                            <p>6 Courses</p>
                        </div>
                    </div>
                </div>
                <!--end category single -->
                <!--start category single -->
                <div class="col-md-3">
                    <div class="category-single text-center">
                        <div class="course-category-img">
                            <a href="#"><img src="{{ asset('assets/templates/omexo/assets/images/cat-1.jpg') }}"
                                    class="img-fluid" alt="image"></a>
                        </div>
                        <div class="category-cont text-center">
                            <h4><a href="#">Web Design</a></h4>
                            <p>7 Courses</p>
                        </div>
                    </div>
                </div>
                <!--end category single -->
            </div>
            <div class="row">
                <div class="col-lg-12 btn-default text-center">
                    <a href="#">all categories</a>
                </div>
            </div>
        </div>
    </section>
    <!--end category area-->
    <!--start course area-->
    @if (count($courses) > 0)
        <section class="course-area bg-gray">
            <div class="container">
                <div class="row">
                    <!--start heading-->
                    <div class="col-lg-8 offset-lg-2">
                        <div class="sec-heading text-center">
                            <h4>courses</h4>
                            <h2>Explore Popular Courses</h2>
                        </div>
                    </div>
                    <!--end heading-->
                </div>
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-lg-4 col-md-6">
                            <div class="course-card">
                                <div class="course-thumbnail">
                                    <a href="{{ Auth::user() ? '#' : '/auth/register/' . $course->slug }}">
                                        <img src="{{ asset('assets/images/courses/' . $course->image) }}"
                                            class="img-fluid course-image" alt="{{ $course->name }}">
                                    </a>
                                </div>
                                <div class="course-content">
                                    @if ($course->crossed_price > $course->price)
                                        <span class="course-price">
                                            <del>Rp. {{ number_format($course->crossed_price) }}</del>
                                        </span>
                                        <br>
                                    @endif
                                    <span class="course-price">Rp. {{ number_format($course->price) }}</span>
                                    <h3 class="course-title">
                                        <a
                                            href="{{ Auth::user() ? '#' : '/auth/register/' . $course->slug }}">{{ $course->name }}</a>
                                    </h3>
                                    {{-- <div class="course-rating">
                                        <span class="star-rating-group">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        </span>
                                        <span class="course-rating-count">(2 Review)</span>
                                    </div> --}}
                                    <div class="course-content-footer">
                                        <ul>
                                            <li class="course-duration">
                                                <i class="fa fa-clock-o"></i>
                                                {{ getDurationString($course->duration) }}
                                            </li>
                                            {{-- <li class="course-user"><i class="fa fa-user-o"></i> 3</li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="category-btn btn-default text-center">
                            <a href="#">all courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!--end course area-->
    
    <!--start testimonial-area-->
    <section class="testimonial-area">
        <div class="container">
            <div class="row">
                <!--start sec-heading-->
                <div class="col-lg-8 offset-lg-2">
                    <div class="sec-heading text-center">
                        <h4>testimonial</h4>
                        <h2>What Says Our Students</h2>
                    </div>
                </div>
            </div>
            <!--end sec-heading-->
            <div class="row">
                <!--start testi-single-->
                <div class="col-md-4">
                    <div class="testi-single">
                        <div class="testi-cont-inner">
                            <div class="testi-quote">
                                <i class="fa fa-quote-right"></i>
                            </div>
                            <div class="testi-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. aliquet
                                nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis.</p>
                        </div>
                        <div class="testi-client-info">
                            <div class="testi-client-img">
                                <img src="{{ asset('assets/templates/omexo/assets/images/client-1.jpg') }}"
                                    class="img-fluid" alt="image">
                            </div>
                            <div class="testi-client-details">
                                <h4>Adam Smith</h4>
                                <h6>Graphics Designer</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end testi-single-->
                <!--start testi-single-->
                <div class="col-md-4">
                    <div class="testi-single mt-0">
                        <div class="testi-cont-inner">
                            <div class="testi-quote">
                                <i class="fa fa-quote-right"></i>
                            </div>
                            <div class="testi-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. aliquet
                                nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis.</p>
                        </div>
                        <div class="testi-client-info">
                            <div class="testi-client-img">
                                <img src="{{ asset('assets/templates/omexo/assets/images/client-1.jpg') }}"
                                    class="img-fluid" alt="image">
                            </div>
                            <div class="testi-client-details">
                                <h4>Jack Morkel</h4>
                                <h6>Web Developer</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end testi-single-->
                <!--start testi-single-->
                <div class="col-md-4">
                    <div class="testi-single">
                        <div class="testi-cont-inner">
                            <div class="testi-quote">
                                <i class="fa fa-quote-right"></i>
                            </div>
                            <div class="testi-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. aliquet
                                nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis.</p>
                        </div>
                        <div class="testi-client-info">
                            <div class="testi-client-img">
                                <img src="{{ asset('assets/templates/omexo/assets/images/client-1.jpg') }}"
                                    class="img-fluid" alt="image">
                            </div>
                            <div class="testi-client-details">
                                <h4>John Doe</h4>
                                <h6>Affiliate Marketer</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end testi-single-->
            </div>
        </div>
    </section>
    <!--end testimonial area-->
    
    <!--start why choose area-->
    <section class="why-choose-area">
        <div class="container">
            <div class="row">
                <!--start why choose heading-->
                <div class="col-md-4">
                    <div class="why-choose-intro">
                        <h2>Why Choose Us?</h2>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat.</p>
                        <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci.</p>
                        <div class="why-choose-btn">
                            <a href="#">Learn More</a>
                        </div>
                    </div>
                </div>
                <!--end why choose heading-->
                <div class="col-md-8">
                    <div class="row">
                        <!--start why choose single-->
                        <div class="col-md-6">
                            <div class="why-choose-single">
                                <div class="why-choose-icon">
                                    <img src="{{ asset('assets/templates/omexo/assets/images/icons/ribbon.svg') }}"
                                        class="img-fluid" alt="image">
                                </div>
                                <div class="why-choose-cont">
                                    <h3>High Quality Courses</h3>
                                    <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet
                                        orci. Aenean dignissim.</p>
                                </div>
                            </div>
                        </div>
                        <!--end why choose single-->
                        <!--start why choose single-->
                        <div class="col-md-6">
                            <div class="why-choose-single">
                                <div class="why-choose-icon">
                                    <img src="{{ asset('assets/templates/omexo/assets/images/icons/teacher.svg') }}"
                                        class="img-fluid" alt="image">
                                </div>
                                <div class="why-choose-cont">
                                    <h3>Expert Instructors</h3>
                                    <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet
                                        orci. Aenean dignissim.</p>
                                </div>
                            </div>
                        </div>
                        <!--end why choose single-->
                        <!--start why choose single-->
                        <div class="col-md-6">
                            <div class="why-choose-single">
                                <div class="why-choose-icon">
                                    <img src="{{ asset('assets/templates/omexo/assets/images/icons/folder.svg') }}"
                                        class="img-fluid" alt="image">
                                </div>
                                <div class="why-choose-cont">
                                    <h3>Life Time Access</h3>
                                    <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet
                                        orci. Aenean dignissim.</p>
                                </div>
                            </div>
                        </div>
                        <!--end why choose single-->
                        <!--start why choose single-->
                        <div class="col-md-6">
                            <div class="why-choose-single">
                                <div class="why-choose-icon">
                                    <img src="{{ asset('assets/templates/omexo/assets/images/icons/24-hours.svg') }}"
                                        class="img-fluid" alt="image">
                                </div>
                                <div class="why-choose-cont">
                                    <h3>Dedicated Support</h3>
                                    <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet
                                        orci. Aenean dignissim.</p>
                                </div>
                            </div>
                        </div>
                        <!--end why choose single-->
                    </div>
                </div>
                <!--end choose single-->
            </div>
        </div>
    </section>
    <!--end why choose area-->
   
    
@endsection
<!--end footer-->
