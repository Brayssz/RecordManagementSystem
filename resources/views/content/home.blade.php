@extends('welcome')

@section('title', 'Home')

@section('content')

    <!-- slider Area Start-->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="slider-active">
            <div class="single-slider slider-height d-flex align-items-center"
                data-background="img/h1_hero.jpg" style="background-color: rgba(0, 0, 0, 0.6); background-blend-mode: darken;">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-9 col-md-10">
                            <div class="hero__caption">
                                <h1 style="color: white;" class="mb-3">Find the most exciting startup jobs</h1>
                                <h3 style="color: rgb(185, 185, 185);" class="mb-5">Committed to serve through strategic alliance with globally competitive people towards excellence!</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Search Box -->
                    <div class="row">
                        <div class="col-xl-8">
                            <!-- form -->
                            <form action="#" class="search-box">
                                <div class="search-form rounded-6">
                                    <a href="#">Get Started</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!-- Our Services Start -->
    <section class="support-company-area fix section-padding2" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="right-caption">
                        <!-- Section Tittle -->
                        <div class="section-tittle section-tittle2">
                            <span>Our Mission</span>
                            <h2>Connecting Talent with Opportunity</h2>
                        </div>
                        <div class="support-caption">
                            <p class="pera-top">We specialize in bridging the gap between skilled professionals and top organizations, ensuring the perfect match for both.</p>
                            <p>Our recruitment agency is dedicated to providing exceptional service, helping businesses find the right talent while empowering individuals to achieve their career goals. Let us help you succeed.</p>
                          
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="support-location-img">
                        <img src="img/support-img.jpg" alt="">
                        <div class="support-img-cap text-center">
                            <p>Since</p>
                            <span>1999</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Online CV Area Start -->
    <div class="online-cv cv-bg section-overly pt-90 pb-120" data-background="assets/img/gallery/cv_bg.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="cv-caption text-center">
                        <p class="pera1">FEATURED TOURS Packages</p>
                        <p class="pera2"> Make a Difference with Your Online Resume!</p>
                        <a href="#" class="border-btn2 border-btn4">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Online CV Area End-->
    <!-- Featured_job_start -->
    <section class="featured-job-area feature-padding" id="featured_job">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle text-center">
                        <span>Top 10 Jobs</span>
                        <h2>Featured Jobs</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">

               
                <div class="col-xl-10">
                    @foreach ($featuredJobs as $featuredJob)
                        <div class="single-job-items mb-30 rounded-4 shadow-md">
                            <div class="job-items">
                                <div class="company-img">
                                    <a href="job_details.html">
                                        <img src="{{ $featuredJob->employer->profile_photo_path ? asset('storage/' . $featuredJob->employer->profile_photo_path) : asset('img/no-profile.png') }}" alt="" width="100px" height="100px">
                                    </a>
                                </div>
                                <div class="job-tittle">
                                    <a href="job_details.html">
                                        <h4>{{$featuredJob->job_title}}</h4>
                                    </a>
                                    <ul>
                                        <li>{{$featuredJob->employer->company_name}}</li>
                                        <li><i class="fas fa-map-marker-alt"></i>{{$featuredJob->country}}</li>
                                        <li>₱ {{$featuredJob->salary}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="items-link f-right">
                                <a href="job-offers">View All</a>
                                <span>{{ $featuredJob->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div class="apply-process-area apply-bg pt-150 pb-150" data-background="assets/img/gallery/how-applybg.png">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle white-text text-center">
                        <span>Apply process</span>
                        <h2> How it works</h2>
                    </div>
                </div>
            </div>
            <!-- Apply Process Caption -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-process text-center mb-30">
                        <div class="process-ion">
                            <span class="flaticon-search"></span>
                        </div>
                        <div class="process-cap">
                            <h5>1. Search a job</h5>
                            <p>Explore a wide range of job opportunities tailored to your skills and preferences.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-process text-center mb-30">
                        <div class="process-ion">
                            <span class="flaticon-curriculum-vitae"></span>
                        </div>
                        <div class="process-cap">
                            <h5>2. Apply for job</h5>
                            <p>Submit your application and showcase your skills to potential employers for the job you desire.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-process text-center mb-30">
                        <div class="process-ion">
                            <span class="flaticon-tour"></span>
                        </div>
                        <div class="process-cap">
                            <h5>3. Process Transaction</h5>
                            <p>Complete the necessary steps to finalize your application and secure your position with ease.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
