@php
        $shapeBase = asset('assets/images/banner/shape');
    @endphp
    <div class="banner-swiper-two">
        <div class="swiper mySwiper-banner-two">
            <div class="swiper-wrapper">
                @forelse($heroSlides ?? [] as $slide)
                    @php($heroDualBg = $slide->hasSmallDeviceBackground())
                    <div class="swiper-slide">
                        <div class="{{ $slide->variantClasses() }} home-hero-slide-bg{{ $heroDualBg ? ' home-hero-slide-bg--dual' : '' }}" style="{{ $heroDualBg ? $slide->bannerDualBackgroundStyle() : $slide->bannerBackgroundStyle() }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="banner-inner-two-content">
                                            @if(filled($slide->pre_title_span) || filled($slide->pre_title_rest))
                                                <p class="pre-title">
                                                    @if(filled($slide->pre_title_span))
                                                        <span>{{ $slide->pre_title_span }}</span>
                                                    @endif
                                                    @if(filled($slide->pre_title_rest))
                                                        {{ $slide->pre_title_rest }}
                                                    @endif
                                                </p>
                                            @endif
                                            @if(filled($slide->title))
                                                <h1 class="title">{!! nl2br(e($slide->title)) !!}</h1>
                                            @endif
                                            @if(filled($slide->disc))
                                                <p class="disc">{{ $slide->disc }}</p>
                                            @endif
                                            @if(filled($slide->button_label))
                                                <a href="{{ $slide->resolvedButtonUrl() ?: '#' }}" class="rts-btn btn-primary btn-white">{{ $slide->button_label }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shape-area-start">
                                <div class="shape shape-one">
                                    <img loading="lazy" src="{{ $shapeBase }}/01.webp" alt="">
                                </div>
                                <div class="shape shape-two">
                                    <img loading="lazy" src="{{ $shapeBase }}/02.webp" alt="">
                                </div>
                                <div class="shape shape-three">
                                    <img loading="lazy" src="{{ $shapeBase }}/03.webp" alt="">
                                </div>
                                <div class="shape shape-four">
                                    <img loading="lazy" src="{{ $shapeBase }}/04.webp" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="rts-banner-area-two rts-section-gap bg_image">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="banner-inner-two-content">
                                            <p class="pre-title"><span>Welcome!</span> Start Growing Your Business Today</p>
                                            <h1 class="title">Innovative Solutions <br> Tailored for Your Success</h1>
                                            <p class="disc">
                                                Porttitor ornare fermentum aliquam pharetra facilisis gravida risus suscipit
                                                Dui feugiat
                                                fusce conubia ridiculus tristique parturient
                                            </p>
                                            <a href="#" class="rts-btn btn-primary btn-white">Get Consultant</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shape-area-start">
                                <div class="shape shape-one">
                                    <img loading="lazy" src="{{ $shapeBase }}/01.webp" alt="shape-area">
                                </div>
                                <div class="shape shape-two">
                                    <img loading="lazy" src="{{ $shapeBase }}/02.webp" alt="shape-area">
                                </div>
                                <div class="shape shape-three">
                                    <img loading="lazy" src="{{ $shapeBase }}/03.webp" alt="shape-area">
                                </div>
                                <div class="shape shape-four">
                                    <img loading="lazy" src="{{ $shapeBase }}/04.webp" alt="shape-area">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="rts-banner-area-two two rts-section-gap bg_image">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="banner-inner-two-content">
                                            <p class="pre-title"><span>Welcome!</span> Start Growing Your Business Today</p>
                                            <h1 class="title">Impressive Solutions <br> Crafted for Your Goal</h1>
                                            <p class="disc">
                                                Porttitor ornare fermentum aliquam pharetra facilisis gravida risus suscipit
                                                Dui feugiat
                                                fusce conubia ridiculus tristique parturient
                                            </p>
                                            <a href="#" class="rts-btn btn-primary btn-white">Get Consultant</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shape-area-start">
                                <div class="shape shape-one">
                                    <img loading="lazy" src="{{ $shapeBase }}/01.webp" alt="">
                                </div>
                                <div class="shape shape-two">
                                    <img loading="lazy" src="{{ $shapeBase }}/02.webp" alt="">
                                </div>
                                <div class="shape shape-three">
                                    <img loading="lazy" src="{{ $shapeBase }}/03.webp" alt="">
                                </div>
                                <div class="shape shape-four">
                                    <img loading="lazy" src="{{ $shapeBase }}/04.webp" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="rts-banner-area-two three rts-section-gap bg_image">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="banner-inner-two-content">
                                            <p class="pre-title"><span>Welcome!</span> Start Growing Your Business Today</p>
                                            <h1 class="title">Best Solutions <br> Intro for Your Business</h1>
                                            <p class="disc">
                                                Porttitor ornare fermentum aliquam pharetra facilisis gravida risus suscipit
                                                Dui feugiat
                                                fusce conubia ridiculus tristique parturient
                                            </p>
                                            <a href="#" class="rts-btn btn-primary btn-white">Get Consultant</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shape-area-start">
                                <div class="shape shape-one">
                                    <img loading="lazy" src="{{ $shapeBase }}/01.webp" alt="">
                                </div>
                                <div class="shape shape-two">
                                    <img loading="lazy" src="{{ $shapeBase }}/02.webp" alt="">
                                </div>
                                <div class="shape shape-three">
                                    <img loading="lazy" src="{{ $shapeBase }}/03.webp" alt="">
                                </div>
                                <div class="shape shape-four">
                                    <img loading="lazy" src="{{ $shapeBase }}/04.webp" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-button-next"><i class="fa-light fa-chevron-right"></i></div>
            <div class="swiper-button-prev"><i class="fa-light fa-chevron-left"></i></div>
        </div>
    </div>

    @include('frontend.partials.sections.about-talent-section')

    @include('frontend.partials.sections.home-services-section')

    @include('frontend.partials.sections.hildes-grow-business-cta')

    <!-- rts business goal area start -->
    <div class="business-goal-area-2 rts-section-gap">
        <div class="container pt--30">
            <div class="row">
                <div class="col-lg-6">
                    <div class="consultancy-style-one">
                        <div class="title-style-two mb--40 left">
                            <span class="bg-content">Business Goal</span>
                            <span class="pre">TRUSTED DIGITAL PARTNER</span>
                            <h2 class="title rts-text-anime-style-1">We build and scale businesses globally <br>
                                <a href="{{ $homeSvcHrefSaaS }}" style="color: inherit;">SaaS Platforms</a> &amp; <a href="{{ $homeSvcHrefAi }}" style="color: inherit;">AI Solutions</a>
                            </h2>
                        </div>
                        <div class="signle-consultancy mb--30">
                            <div class="icon">
                                <i class="fa-solid fa-robot" aria-hidden="true"></i>
                            </div>
                            <div class="information">
                                <h4 class="title"><a href="{{ $homeSvcHrefSaaS }}" style="color: inherit;">SaaS Platforms</a> &amp; <a href="{{ $homeSvcHrefAi }}" style="color: inherit;">AI Solutions</a></h4>
                                <p class="disc">
                                    Custom <a href="{{ $homeSvcHrefSaaS }}" style="color: inherit;">SaaS</a> products, <a href="{{ $homeSvcHrefAi }}" style="color: inherit;">AI</a> automation, smart systems, and scalable software designed to grow your business.
                                </p>
                            </div>
                        </div>
                        <div class="signle-consultancy">
                            <div class="icon">
                                <i class="fa-solid fa-user-gear" aria-hidden="true"></i>
                            </div>
                            <div class="information">
                                <h4 class="title">Reliable Support &amp; <a href="{{ $homeSvcHrefDedicated }}" style="color: inherit;">Dedicated Teams</a></h4>
                                <p class="disc">
                                    Hourly, project-based, and monthly hiring with expert developers to keep your business moving forward.
                                </p>
                            </div>
                        </div>
                        <div class="button-wrapper mt--40" data-animation="fadeInUp" data-delay="0.4"
                            data-duration="1.2">
                            <a href="/" class="rts-btn btn-primary">Contact Us</a>
                            <div class="vedio-icone">
                                <a class="video-play-button play-video popup-video"
                                    href="https://www.youtube.com/watch?v=vZE0j_WCRvI"
                                    aria-label="Watch promotional video on YouTube">
                                    <span></span>
                                </a>
                                <div class="video-overlay">
                                    <a href="#section1" class="video-overlay-close">×</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="thumbnail-business-area-right-two">
                        <div class="large-thumbnail">
                            <img loading="lazy" src="assets/images/hildes/hildes-professional-team-business-growth-collaboration.png" alt="HilDes professional team collaborating on web development, AI solutions, software projects, and business growth strategy in a modern office workspace.">
                        </div>
                        <div class="small-thumbnail images-r">
                            <img class="hildes-about-small-image" loading="lazy" src="assets/images/hildes/hildes-software-developers-code-collaboration.png" alt="HilDes software developers collaborating on web development, coding, AI solutions, and digital product development in a modern office workspace.">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- rts business goal area end -->
    </div>

    <!-- rts counter up area start -->
    <div class="rts-counter-up-area rts-section-gap counter-bg">
        <div class="container">
            <div class="row g-5">
                <!-- counter up area -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-counter">
                        <div class="icon">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                        </div>
                        <div class="counter-details">
                            <h2 class="counter title"><span class="odometer" data-count="13">00</span>+
                            </h2>
                            <p class="disc">Years Experience</p>
                        </div>
                    </div>
                </div>
                <!-- counter up area -->
                <!-- counter up area -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-counter pl--10 justify-content-center two pl--30">
                        <div class="icon">
                            <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                        </div>
                        <div class="counter-details">
                            <h2 class="counter title"><span class="odometer" data-count="200">00</span>+
                            </h2>
                            <p class="disc">Projects Delivered</p>
                        </div>
                    </div>
                </div>
                <!-- counter up area -->
                <!-- counter up area -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-counter pl--10 justify-content-center three pl--50 pl_md--10 pl_sm--0">
                        <div class="icon">
                            <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
                        </div>
                        <div class="counter-details">
                            <h2 class="counter title"><span class="odometer" data-count="40">00</span>+
                            </h2>
                            <p class="disc">Tools Integrated</p>
                        </div>
                    </div>
                </div>
                <!-- counter up area -->
                <!-- counter up area -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-counter pl--10 four">
                        <div class="icon">
                            <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                        </div>
                        <div class="counter-details">
                            <h2 class="counter title"><span class="odometer" data-count="12000">00</span>+
                            </h2>
                            <p class="disc">Tasks Managed</p>
                        </div>
                    </div>
                </div>
                <!-- counter up area -->
            </div>
        </div>
    </div>
    <!-- rts counter up area end -->

    @include('frontend.partials.sections.case-studies-section')
     
    <!-- rts trusted client area start -->
    <div class="rts-trusted-client rts-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-area-client-client text-center">
                        <p class="client-title">Our Trusted Clients</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @php($clientLogos = collect($homepageClients ?? []))
                <div class="hildes-clients-marquee" aria-label="Our trusted clients">
                    <div class="hildes-clients-track">
                        @for($group = 0; $group < 2; $group++)
                            <div class="hildes-clients-group" @if($group === 1) aria-hidden="true" @endif>
                                @forelse($clientLogos as $clientItem)
                                    <a href="{{ filled($clientItem->website_url) ? $clientItem->website_url : '#' }}"
                                       class="hildes-client-pill"
                                       style="background: {{ $clientItem->background_color ?: '#FFFFFF' }};"
                                       @if(filled($clientItem->website_url)) target="_blank" rel="noopener noreferrer" @endif>
                                        <img src="{{ $clientItem->logo_url }}" alt="{{ $clientItem->name ?: 'client logo' }}">
                                    </a>
                                @empty
                                    <a href="#" class="hildes-client-pill"><img src="assets/images/client/1.webp" alt="client logo"></a>
                                    <a href="#" class="hildes-client-pill"><img src="assets/images/client/2.webp" alt="client logo"></a>
                                    <a href="#" class="hildes-client-pill"><img src="assets/images/client/3.webp" alt="client logo"></a>
                                    <a href="#" class="hildes-client-pill"><img src="assets/images/client/4.webp" alt="client logo"></a>
                                    <a href="#" class="hildes-client-pill"><img src="assets/images/client/5.webp" alt="client logo"></a>
                                    <a href="#" class="hildes-client-pill"><img src="assets/images/client/6.webp" alt="client logo"></a>
                                @endforelse
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts trusted client area end -->

    <!-- rts clients review area start -->
    <div class="rts-client-review-area rts-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between-wrapper" dir="ltr">
                        <div class="title-style-two mb--40 left">
                            <span class="bg-content">Review</span>
                            <span class="pre">Our Testimonial</span>
                            <h2 class="title ">Our Client Reviews
                            </h2>
                        </div>
                        <div class="pagination-wrapper">
                            <div class="swiper-pagination-fraction"></div>
                            <div class="swiper-button-next"><i class="fa-sharp fa-regular fa-arrow-right"></i></div>
                            <div class="swiper-button-prev"><i class="fa-sharp fa-regular fa-arrow-left"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="testimonials-wrapper-swiper-demo-2">
                        <div class="swiper mySwiper-testimonials-dmeo-2" dir="ltr">
                            <div class="swiper-wrapper">
                                @forelse(($homepageTestimonials ?? collect()) as $testimonial)
                                    <div class="swiper-slide">
                                        <div class="testimonials-main-wrapper-two">
                                            <div class="left-thumbnail">
                                                <img loading="lazy" src="{{ $testimonial->image_url }}"
                                                    alt="{{ $testimonial->image_alt ?: ($testimonial->name ?: 'testimonial') }}">
                                            </div>
                                            <div class="right-content-testimonials">
                                                <p class="disc">
                                                    {{ $testimonial->description }}
                                                </p>
                                                <div class="name-desig">
                                                    <h6 class="title">{{ $testimonial->name }}</h6>
                                                    @if($testimonial->designation || $testimonial->company)
                                                        <p>
                                                            {{ $testimonial->designation ?: 'Professional' }}
                                                            @if($testimonial->company)
                                                                at <b>{{ $testimonial->company }}</b>
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div class="testimonials-main-wrapper-two">
                                            <div class="left-thumbnail">
                                                <img loading="lazy" src="assets/images/testimonials/01.webp" alt="testimonials">
                                            </div>
                                            <div class="right-content-testimonials">
                                                <p class="disc">
                                                    Your client testimonials will appear here once you add them from admin.
                                                </p>
                                                <div class="name-desig">
                                                    <h6 class="title">HilDes Client</h6>
                                                    <p>Partner at <b>Growth Company</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts clients review area end -->

    <!-- appoinment areas tart -->
    <div class="appoinment-area-start rts-section-gapBottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="appoinment-wrapper-one-start">
                        <div class="title-style-two mb--40 left">
                            <span class="bg-content">Hello</span>
                            <span class="pre">START YOUR PROJECT</span>
                            <h2 class="title">Request a Free Consultation</h2>
                            <p class="disc mt--15">Tell us about your business needs and our team will contact you shortly.</p>
                        </div>
                        <form method="POST" action="{{ route('lead-submissions.store') }}" data-ajax-lead-form>
                            @csrf
                            <input type="hidden" name="source" value="consultation">
                            <div class="single-input-wrapper">
                                <div class="single-input">
                                    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Full Name" autocomplete="name">
                                </div>
                                <div class="single-input">
                                    <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" autocomplete="organization">
                                </div>
                            </div>
                            <div class="single-input-wrapper">
                                <div class="single-input">
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="email">
                                </div>
                                <div class="single-input">
                                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Contact Number / WhatsApp" autocomplete="tel">
                                </div>
                            </div>
                            <div class="single-input">
                                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject">
                            </div>
                            <div class="single-input mb--30">
                                <textarea name="message" placeholder="Tell us about your project requirements" rows="5">{{ old('message') }}</textarea>
                            </div>
                            <p class="hildes-ajax-form-status" data-form-status aria-live="polite"></p>
                            <button type="submit" class="rts-btn btn-primary" data-submit-label="Get Free Consultation"><span class="hildes-ajax-btn-text">Get Free Consultation</span></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="appoinment-thumbnail">
                        <img class="hildes-about-small-image" loading="lazy" src="assets/images/hildes/hildes-client-consultation-contact-support.png" alt="HilDes team member discussing project requirements with clients during a professional consultation for web development, SaaS platforms, AI solutions, and business support services.">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- appoinment areas end -->

    <!-- rts blog area start -->
    <div class="rts-blog-area rts-section-gapBottom pt--40 mb--310">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-style-two center">
                        <span class="bg-content">Blog</span>
                        <span class="pre">Blog & News</span>
                        <h2 class="title">Recent blog post
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row g-5 mt--20">
                <div class="col-lg-12">
                    <div class="blog-swiper-style-one">
                        <div class="swiper mySwiper-blog-one">
                            <div class="swiper-wrapper">
                                @foreach($recentBlogPosts ?? [] as $post)
                                    <div class="swiper-slide">
                                        <div class="single-blog-area-one">
                                            <p>{{ $post->category_name }} / <span>by {{ $post->author_name }}</span></p>
                                            <a href="{{ $post->url }}">
                                                <h4 class="title">{{ $post->post_title }}</h4>
                                            </a>
                                            <div class="bottom-details">
                                                <a href="{{ $post->url }}" class="thumbnail">
                                                    <img loading="lazy" src="{{ filled($post->image_url) ? $post->image_url : asset($post->fallback_image) }}" alt="{{ $post->post_title }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts blog area end -->
