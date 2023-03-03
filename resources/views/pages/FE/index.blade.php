@extends('layouts.FE.index')
@push('style')
    @include('components.styles.FE.index')
@endpush
@section('content')
    <!--start category area-->
    @if (count($testi_alumnus) > 0)
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
            @foreach ($testi_alumnus as $testi_alumnu)
                <!--start category single -->
                <div class="col-md-4">
                    <div class="category-single text-center">
                        <a href="#"><img src="{{ asset('/assets/images/testi_alumnus/' . $testi_alumnu->image) }}"
                                class="img-fluid" alt="image"></a>
                        <h4><a href="#">{{$testi_alumnu->name}}</a></h4>
                        <p>{{$testi_alumnu->pekerjaan}}</p>
                    </div>
                </div>
                <!--end category single -->
               
            @endforeach
                
            </div>
            
        </div>
    </section>
    @endif
    <!--end category area-->
       <!--start course area-->
       @if (count($courses) > 0)
        <section class="course-area bg-gray">
            <div class="container">
                
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
                                        <div class="category-btn btn-default text-center">
                                                <a href="{{ Auth::user() ? '#' : '/auth/register/' . $course->slug }}">Join Kelas</a>
                                        </div>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
               
            </div>
        </section>
    @endif
    <!--end course area-->
    
    
    
    <!--start why choose area-->
    @if (count($benefits) > 0)
    <section class="why-choose-area">
        <div class="container">
            <div class="row">
                <!--start why choose heading-->
                
                <div class="col-md-4">
                    <div class="why-choose-intro">
                        <h2>Saya yakin, ini yang sekarang anda alami ;</h2>
                        <p>1. Gaptek</p>
<p>2. Belum pernah main tiktok sama sekali</p>
<p>3. Malu live tiktok karna ga percaya diri</p>
<p>4. Sudah mulai tapi ga ada hasil</p>
<p>5. Ga punya waktu karna sambil kerja</p>
<p>6. Sudah pernah ikut kelas tapi ga ada hasil</p>
<p>7. Bingung mau mulai dari mana</p>
<p>8. Mau mulai bisnis tapi ga punya modal</p>
<p>9. Sering ngiklan tapi boncos terus</p>
<h2>Pas banget...!!!
Mempersembahkan Online Class untuk Bisa Cuan Jutaan Rupiah dari tiktok Affiliate</h2>
                        
                        
                    </div>
                </div>
                <!--end why choose heading-->
                <div class="col-md-8">
                    <div class="row">
                        <!--start why choose single-->
                        @foreach ($benefits as $benefit)
                        <div class="col-md-6">
                            <div class="why-choose-single">
                                <div class="why-choose-icon">
                                    <img src="{{ asset('/assets/images/benefits/' . $benefit->image) }}"
                                        class="img-fluid" alt="image">
                                </div>
                                <div class="why-choose-cont">
                                    <h3>{{$benefit->name}}</h3>
                                    <div style="word-wrap: break-word;">
                                    {!! $benefit->detail !!}
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <!--end why choose single-->
                        @endforeach
                        
                       
                       
                    </div>
                </div>
                <!--end choose single-->
            </div>
        </div>
    </section>
    @endif
    <!--end why choose area-->
    <!--start newsletter area-->
    @if (count($qnas) > 0)
    <section class="newsletter-area">
        <div class="container">
        <div class="course-curriculum">
                                        <h3>QnA Pertanyaan yang sering muncul !</h3>
                                        <div id="accordion">
                                        @foreach ($qnas as $qna)
                                            <!--start curriculum single-->
                                            <div class="card">
                                                <div class="card-header two">
                                                    <a class="card-link" data-toggle="collapse" href="#collapseTwo{{$qna->id}}">
                                                        <div style="word-wrap: break-word;">
                                    {!! $qna->detail_pertanyaan !!}
                                    </div></a>
                                                </div>
                                                <div id="collapseTwo{{$qna->id}}" class="collapse" data-parent="#accordion">
                                                    <div class="card-body current">
                                                        <div class="course-lesson">
                                                        <div style="word-wrap: break-word;">
                                    {!! $qna->detail_jawaban !!}
                                    </div>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end curriculum single-->
                                        @endforeach
                                        </div>
                                    </div>
        </div>
    </section>
    @endif
    <!--end newsletter area-->
   
    
@endsection
<!--end footer-->
