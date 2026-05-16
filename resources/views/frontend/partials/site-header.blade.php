<header class="header-one header--sticky">
    <div class="header-top-area-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-top-one-wrapper">
                        <div class="left">
                            @if(filled($contact->email))
                            <div class="mail">
                                <a href="{{ $contact->mailtoHref() }}"><i class="fal fa-envelope"></i> {{ $contact->email }}</a>
                            </div>
                            @endif
                        </div>
                        <div class="right">
                            <ul class="top-nav">
                                <li><a href="{{ route('faqs.page') }}">Faq</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                            <ul class="social-wrapper-one">
                                <li><a href="{{ $contact->github ?: '#' }}" @if($contact->github) target="_blank" rel="noopener noreferrer" @endif aria-label="GitHub"><i class="fab fa-github"></i></a></li>
                                <li><a href="{{ $contact->linkedin ?: '#' }}" @if($contact->linkedin) target="_blank" rel="noopener noreferrer" @endif aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a class="mr--0" href="{{ $contact->facebook ?: '#' }}" @if($contact->facebook) target="_blank" rel="noopener noreferrer" @endif aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-main-one-wrapper">
                        <div class="thumbnail">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="HilDes">
                                <span class="hildes-brand-text">HilDes</span>
                            </a>
                        </div>
                        <div class="main-header">
                            <div class="nav-area">
    <ul class="">
        <li class="main-nav project-a-after">
            <a href="{{ route('home') }}">Home</a>
        </li>
        <li class="main-nav project-a-after">
            <a href="{{ route('about') }}">About Us</a>
        </li>
        <li class="main-nav has-dropdown mega-menu">
            <a href="#">Service</a>
            <div class="rts-mega-menu service-mega-menu-style">
                <div class="wrapper">
                    <div class="container">
                        @php
                            $headerServices = collect($headerServices ?? [])->take(9)->values();
                        @endphp
                        <div class="row g-3 service-menu-grid-row">
                            @foreach($headerServices as $serviceItem)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('service.slug', $serviceItem->slug) }}">
                                        <div class="single-service-menu single-service-menu--compact">
                                            <div class="icon">
                                                <i class="fa-sharp fa-regular fa-chevron-right"></i>
                                            </div>
                                            <div class="info">
                                                <h5 class="title">{{ $serviceItem->name }}</h5>
                                                <p class="details">{{ \Illuminate\Support\Str::limit(strip_tags((string) $serviceItem->hero_headline), 70) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            <div class="col-12 text-center">
                                <a href="{{ route('services.index') }}" class="service-menu-all-link">All Services</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="main-nav has-dropdown mega-menu">
            <a href="#">Case Studies &amp; Projects</a>
            <div class="rts-mega-menu service-mega-menu-style">
                <div class="wrapper">
                    <div class="container">
                        @php
                            $headerCaseStudies = collect($headerCaseStudies ?? [])->values();
                        @endphp
                        <div class="row g-3 service-menu-grid-row">
                            @foreach($headerCaseStudies as $caseStudyItem)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('case-studies.show', $caseStudyItem->slug) }}">
                                        <div class="single-service-menu single-service-menu--compact">
                                            <div class="icon">
                                                <i class="fa-sharp fa-regular fa-chevron-right"></i>
                                            </div>
                                            <div class="info">
                                                <h5 class="title">{{ $caseStudyItem->title }}</h5>
                                                <p class="details">{{ \Illuminate\Support\Str::limit(strip_tags((string) $caseStudyItem->tagline), 70) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            <div class="col-12 text-center">
                                <a href="{{ route('case-studies.index') }}" class="service-menu-all-link">All Case Studies</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="main-nav project-a-after">
            <a href="https://www.hildes.io/blog">Blog</a>
        </li>
        <li class="main-nav project-a-after">
            <a href="{{ route('contact') }}">Contact Us</a>
        </li>
    </ul>
</div>


<div class="loader-wrapper">
    <div class="loader">
    </div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
                            <div class="button-area">
                                <button class="search" id="search" aria-label="Search"><i
                                        class="far fa-search"></i></button>
                                <a href="{{ route('quote') }}"
                                    class="rts-btn btn-primary ml--20 ml_sm--5 header-one-btn quote-btn">Get
                                    Quote</a>
                                <button id="menu-btn" aria-label="Menu" class="menu-btn menu ml--20 ml_sm--5">
                                    <img class="menu-light" src="{{ asset('assets/images/icons/01.svg') }}" alt="Menu-icon">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
