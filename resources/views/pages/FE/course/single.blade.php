@extends('layouts.FE.page')
@section('content')
    <section class="page-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="banner-content text-center">
                        <h1>{{ $title }}</h1>
                        <p>
                            Home
                            <span> > </span>
                            <a href="{{ url('/courses') }}">Courses</a>
                            <span> > </span>
                            {{ $title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="course-single-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="course-single-content">
                        <!--start course meta-->
                        <div class="course-single-meta">
                            <div class="course-author">
                                <img src="{{ asset('assets/templates/omexo/assets/images/client-1.jpg') }}" alt="Image">
                                <span>by</span>
                                <strong>Admin</strong>
                            </div>
                            {{-- <div class="course-rating">
                                <span><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                        class="fa fa-star"></i><i class="fa fa-star"></i></span>
                                <span>5.00 ( 8 Ratings)</span>
                            </div>
                            <div class="course-whishlist">
                                <i class="fa fa-bookmark"></i>Wishlist
                            </div>
                            <div class="course-reply">
                                <i class="fa fa-share"></i>Share
                            </div> --}}
                        </div>
                        <!--end course meta-->
                        {{-- <div class="course-categories">
                            <ul>
                                <li><span>Categories:</span></li>
                                <li><a href="#">Business</a></li>
                                <li><a href="#">Marketing</a></li>
                                <li><a href="#">Photography</a></li>
                            </ul>
                        </div> --}}
                        <!--start course tab-->
                        <div class="course-content-tab">
                            <!--start tab menu-->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link show active" id="course-info-tab" data-toggle="tab"
                                        href="#course-info" role="tab" aria-controls="course-info"
                                        aria-selected="true">Course Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link show" id="curriculum-tab" data-toggle="tab" href="#curriculum"
                                        role="tab" aria-controls="curriculum" aria-selected="false">Curriculum</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link show" id="reviews-tab" data-toggle="tab" href="#reviews"
                                        role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                                </li> --}}
                            </ul>
                            <!--sendtart tab menu-->
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="course-info" role="tabpanel"
                                    aria-labelledby="course-info-tab">
                                    {!! $course->detail !!}
                                </div>
                                <div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">
                                    <div class="course-curriculum">
                                        <h3>Course Curriculum</h3>
                                        <div id="accordion">
                                            <div class="card active">
                                                <div class="card-body current">
                                                    @foreach ($videos as $video)
                                                        <div class="course-lesson">
                                                            <p>
                                                                <span>
                                                                    <i class="fa fa-youtube-play"></i> {{ $video->name }}
                                                                </span>
                                                                <span class="lesson-text float-right">{{ $video->duration }}
                                                                    <i class="fa fa-lock"></i>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                    <div class="review-contents">
                                        <h3>Student Ratings &amp; Reviews</h3>
                                        <div class="review-content-inner">
                                            <div class="review-ratings">
                                                <h2>5.0</h2>
                                                <span><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i></span>
                                                <p>Total 7 Ratings</p>
                                            </div>
                                            <div class="rating-bar">
                                                <div class="rating-star">5</div>
                                                <div class="rating-progress"><span class="rating-progress-value"></span>
                                                </div>
                                                <div class="review-text">2 ratings</div>
                                            </div>
                                            <div class="rating-bar">
                                                <div class="rating-star">4</div>
                                                <div class="rating-progress"></div>
                                                <div class="review-text">0 ratings</div>
                                            </div>
                                            <div class="rating-bar">
                                                <div class="rating-star">3</div>
                                                <div class="rating-progress"></div>
                                                <div class="review-text">0 ratings</div>
                                            </div>
                                            <div class="rating-bar">
                                                <div class="rating-star">3</div>
                                                <div class="rating-progress"></div>
                                                <div class="review-text">0 ratings</div>
                                            </div>
                                            <div class="rating-bar">
                                                <div class="rating-star">1</div>
                                                <div class="rating-progress"></div>
                                                <div class="review-text">0 ratings</div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <!--end course tab-->
                    </div>
                </div>
                <!--start course sidebar-->
                <div class="col-lg-4">
                    <div class="course-sidebar two">
                        <div class="course-single-info course-widget">
                            @if (count($videos) > 0)
                                <div class="course-player">
                                    <video width="380" controls
                                        poster="{{ asset('assets/images/courses/video/poster/' . $course->id . '/' . $videos[0]->poster) }}">
                                        <source
                                            src="{{ asset('assets/videos/courses/' . $course->id . '/' . $videos[0]->video) }}">
                                    </video>
                                </div>
                            @endif
                            <div class="course-price">
                                @if ($course->crossed_price > $course->price)
                                    <span>
                                        <del>Rp. {{ number_format($course->crossed_price) }}</del>
                                    </span>
                                @endif
                                <span>Rp. {{ number_format($course->price) }}</span>
                            </div>
                            <div class="course-enroll-btn text-center">
                                <a href="{{ Auth::user() ? '#' : '/auth/register/' . $course->slug }}">Enroll Course</a>
                            </div>
                            {{-- <div class="course-info-list">
                                <ul>
                                    <li><span><i class="fa fa-bar-chart"></i>Level</span><span class="info float-right">All
                                            Levels</span></li>
                                    <li><span><i class="fa fa-clock-o"></i>Duration</span><span class="info float-right">15
                                            hours 20 minutes</span></li>
                                    <li><span><i class="fa fa-refresh"></i>Last Updated</span><span
                                            class="info float-right">March 19, 2022</span></li>
                                    <li><span><i class="fa fa-graduation-cap"></i>Enrolled</span><span
                                            class="info float-right">50 Students</span></li>
                                    <li><span><i class="fa fa-bookmark"></i>Lessons</span><span class="info float-right">12
                                            Lessons</span></li>
                                </ul>
                            </div>
                        </div> --}}
                            {{-- <div class="course-materials course-widget">
                            <h3>Material Includes</h3>
                            <ul>
                                <li><i class="fa fa-check"></i> 7.5 hours on-demand video</li>
                                <li><i class="fa fa-check"></i> 10 articles</li>
                                <li><i class="fa fa-check"></i> 31 downloadable resources</li>
                                <li><i class="fa fa-check"></i> Full lifetime access</li>
                                <li><i class="fa fa-check"></i> Access on mobile and TV</li>
                                <li><i class="fa fa-check"></i> Certificate of Completion</li>
                            </ul>
                        </div> --}}
                        </div>
                    </div>
                    <!--end course sidebar-->
                </div>
            </div>
    </section>
@endsection
