@php

    $contact = $contact ?? \App\Models\ContactSetting::query()->firstOrCreate([]);

@endphp



<!-- rts about area start -->

<div class="rts-about-area-two rts-section-gap hildes-about-area-service-links">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <div class="left-thumbnail-about-area-two">

                    <img loading="lazy" src="assets/images/hildes/hildes-tech-team-collaboration.png" alt="HilDes expert team providing AI development, DevOps solutions, web development, and mobile app development services while collaborating in a modern workspace.">

                    <div class="small-image">

                        <img class="hildes-about-small-image" loading="lazy" src="assets/images/hildes/hildes-professional-programmer-web-devops-services.png" alt="HilDes professional programmer working on web development, DevOps infrastructure, AI solutions, and software engineering in a modern tech workspace.">

                    </div>

                    <div class="counter-about-area">

                        <h2 class="counter title"><span class="odometer" data-count="13">00</span>+

                        </h2>

                        <span>Years of experience</span>

                    </div>

                </div>

            </div>

            <div class="col-lg-6 mt_sm--80 mt_md--80">

                <div class="about-inner-content-two">

                    <div class="title-style-two left">

                        <span class="bg-content">About Us</span>

                        <span class="pre">More About Us</span>

                        <h2 class="title rts-text-anime-style-1">Hire Expert Talent to Build, <br> Scale &amp; Innovate Faster

                        </h2>

                    </div>

                    <div class="about-between-wrapper">

                        <p class="disc hildes-about-intro-disc">

                            HilDes provides skilled professionals for hourly, project-based, and monthly hiring needs. Hire <a href="{{ $homeSvcHrefAi }}" class="hildes-service-inline-link">AI specialists</a>, <a href="{{ $homeSvcHrefDevops }}" class="hildes-service-inline-link">DevOps engineers</a>, <a href="{{ $homeSvcHrefWeb }}" class="hildes-service-inline-link">web developers</a>, and <a href="{{ $homeSvcHrefMobile }}" class="hildes-service-inline-link">mobile app experts</a> to launch faster, optimize operations, and scale with confidence.

                        </p>

                        <div class="check-wrapper-area">

                            <div class="single-check">

                                <i class="fa-solid fa-circle-check"></i>

                                <p>Hire <a href="{{ $homeSvcHrefAi }}" class="hildes-service-inline-link">AI Engineers &amp; Automation Experts</a></p>

                            </div>

                            <div class="single-check">

                                <i class="fa-solid fa-circle-check"></i>

                                <p><a href="{{ $homeSvcHrefDevops }}" class="hildes-service-inline-link">DevOps, Cloud Setup &amp; Deployment Support</a></p>

                            </div>

                            <div class="single-check">

                                <i class="fa-solid fa-circle-check"></i>

                                <p><a href="{{ $homeSvcHrefWeb }}" class="hildes-service-inline-link">Web Development (Frontend &amp; Backend)</a></p>

                            </div>

                            <div class="single-check">

                                <i class="fa-solid fa-circle-check"></i>

                                <p><a href="{{ $homeSvcHrefMobile }}" class="hildes-service-inline-link">Mobile App Development (iOS &amp; Android)</a></p>

                            </div>

                        </div>

                    </div>

                    <div class="call-and-sign-area two">

                        @if(filled($contact->phone))

                        <div class="call-area">

                            <div class="icon">

                                <i class="fa-sharp fa-regular fa-phone-volume"></i>

                            </div>

                            <div class="information">

                                <span>Hire talent when you need it</span>

                                <a href="{{ $contact->telHref() }}">

                                    <h6 class="title">{{ $contact->phone }}</h6>

                                </a>

                            </div>

                        </div>

                        @endif

                        <div class="sign-area">

                            <span class="hildes-signature-text">Mubashir Ahmed</span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="shape-area">

        <img loading="lazy" src="assets/images/about/shape/01.svg" alt="shape" class="one">

        <img loading="lazy" src="assets/images/about/shape/02.svg" alt="shape" class="two">

    </div>

</div>

<!-- rts about area end -->

