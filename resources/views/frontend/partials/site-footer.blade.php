<!-- rts footer two area wrapper -->
    <div class="rts-footer-area footer-two mt-dec-footer-map bg-footer-two bg_image">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="map-area-main-wrapper">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <div class="map-area-main-footer-two">
                                    @if(filled($contact->google_map_embed))
                                        {!! $contact->google_map_embed !!}
                                    @else
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d29208.07522277672!2d90.423296!3d23.7826795!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1738651440174!5m2!1sen!2sbd"
                                        width="625" height="550" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="Company location on Google Maps"></iframe>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="map-information-2-footer">
                                    <h5 class="title-main">Contact Us</h5>
                                    <img loading="lazy" src="{{ asset('assets/images/footer/02.svg') }}" alt="line" class="line">
                                    <div class="contact-information-main-wrapper">
                                        @if(filled($contact->email))
                                        <div class="signle-contact-information">
                                            <div class="icon">
                                                <i class="fa-regular fa-envelope"></i>
                                            </div>
                                            <div class="information-wrapper">
                                                <span>Work with us</span>
                                                <a href="{{ $contact->mailtoHref() }}">
                                                    <h6 class="title">{{ $contact->email }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        @if(filled($contact->whatsapp))
                                        <div class="signle-contact-information">
                                            <div class="icon">
                                                <i class="fab fa-whatsapp"></i>
                                            </div>
                                            <div class="information-wrapper">
                                                <span>WhatsApp</span>
                                                <a href="{{ $contact->whatsappHref() }}" target="_blank" rel="noopener noreferrer">
                                                    <h6 class="title">{{ $contact->whatsapp }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        @if(filled($contact->phone))
                                        <div class="signle-contact-information">
                                            <div class="icon">
                                                <i class="fa-solid fa-phone"></i>
                                            </div>
                                            <div class="information-wrapper">
                                                <span>Call Us 24/7</span>
                                                <a href="{{ $contact->telHref() }}">
                                                    <h6 class="title">{{ $contact->phone }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        @if(filled($contact->address_line))
                                        <div class="signle-contact-information">
                                            <div class="icon">
                                                <i class="fa-sharp fa-solid fa-location-dot"></i>
                                            </div>
                                            <div class="information-wrapper">
                                                <span>Our Location</span>
                                                <a href="{{ filled($contact->google_map_url) ? $contact->google_map_url : '#' }}" @if(filled($contact->google_map_url)) target="_blank" rel="noopener noreferrer" @endif>
                                                    <h6 class="title">{{ $contact->address_line }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <ul class="social-wrapper-one hildes-contact-social hildes-social-pills" aria-label="Social links">
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
        </div>
        <div class="container bg-shape-f1">
            <!-- rts footer area -->
            <div class="row pt--120 pt_sm--80 pb--80 pb_sm--40">

                <div class="col-xl-4 col-md-6 col-sm-12 col-12">
                    <div class="footer-one-single-wized mid-bg">
                        <div class="wized-title">
                            <h5 class="title">Ways to Work With Us</h5>
                            <img loading="lazy" src="{{ asset('assets/images/footer/01.svg') }}" alt="finbiz_footer">
                        </div>
                        <div class="opening-time-inner">
                            <div class="single-opening">
                                <p class="day">Hourly hiring</p>
                                <p class="time">On-demand experts</p>
                            </div>
                            <div class="single-opening">
                                <p class="day">Project-based</p>
                                <p class="time">Scoped milestones</p>
                            </div>
                            <div class="single-opening mb--30 mb_sm--10">
                                <p class="day">Monthly retainer</p>
                                <p class="time">Dedicated capacity</p>
                            </div>
                            <a href="{{ route('contact') }}" class="rts-btn btn-primary btn-white">Contact Us</a>
                        </div>
                    </div>
                </div>
                <!-- footer mid area end -->
                <div class="col-xl-4 col-md-6 col-sm-12 col-12 pl--50 pl_sm--15">
                    <div class="footer-one-single-wized">
                        <div class="wized-title">
                            <h5 class="title">Quick Links</h5>
                            <img loading="lazy" src="{{ asset('assets/images/footer/01.svg') }}" alt="finbiz_footer">
                        </div>
                        <div class="quick-link-inner">
                            <ul class="links">
                                <li><a href="{{ route('about') }}"><i class="far fa-arrow-right"></i> About Us</a></li>
                                <li><a href="{{ route('services.index') }}"><i class="far fa-arrow-right"></i> Services</a></li>
                                <li><a href="{{ route('case-studies.index') }}"><i class="far fa-arrow-right"></i> Case Studies</a></li>
                                <li><a href="{{ route('careers.page') }}"><i class="far fa-arrow-right"></i> Careers</a></li>
                                <li><a href="{{ route('faqs.page') }}"><i class="far fa-arrow-right"></i> FAQs</a></li>
                                <li><a href="{{ route('contact') }}"><i class="far fa-arrow-right"></i> Contact Us</a></li>
                            </ul>
                            <ul class="links margin-left-70">
                                <li><a href="{{ route('quote') }}"><i class="far fa-arrow-right"></i> Get a Quote</a></li>
                                <li><a href="https://www.hildes.io/blog"><i class="far fa-arrow-right"></i> Blog</a></li>
                                <li><a href="{{ route('why-us.page') }}"><i class="far fa-arrow-right"></i> Why Us</a></li>
                                <li><a href="{{ route('privacy.page') }}"><i class="far fa-arrow-right"></i> Privacy Policy</a></li>
                                <li><a href="{{ route('terms.page') }}"><i class="far fa-arrow-right"></i> Terms &amp; Conditions</a></li>
                                <li><a href="{{ route('sla.page') }}"><i class="far fa-arrow-right"></i> SLA</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- footer mid area -->

                <!-- footer end area post -->
                <div class="col-xl-4 col-md-6 col-sm-12 col-12">
                    <div class="footer-one-single-wized margin-left-65">
                        <div class="wized-title">
                            <h5 class="title">Get Updates</h5>
                            <img loading="lazy" src="{{ asset('assets/images/footer/01.svg') }}" alt="finbiz_footer">
                        </div>
                        <div class="body">
                            <div class="update-wrapper">
                                <p class="disc">Sign up for our latest news &amp; articles. We won’t give you spam
                                    mails.</p>
                                <form class="email-footer-area" method="POST" action="{{ route('newsletter-subscriptions.store') }}" data-ajax-newsletter-form>
                                    @csrf
                                    <input type="email" name="email" placeholder="Enter Email Address" required="">
                                    <button type="submit" title="Submit newsletter form"><span class="hildes-ajax-btn-text"><i class="fas fa-location-arrow"></i></span></button>
                                </form>
                                <p class="hildes-ajax-form-status" data-form-status aria-live="polite"></p>
                                <div class="note-area">
                                    <p><span>Note:</span> We do not publish your email</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer end area post end-->
            </div>
            <!-- rts footer area End -->
        </div>
        <!-- copyright area start -->
        <div class="rts-copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center hildes-footer-legal-wrap">
                            <p class="hildes-footer-brand-line"><strong>HilDes</strong></p>
                            <p class="hildes-footer-tagline">Make Dust, Hill</p>
                            <ul class="social-wrapper-one hildes-footer-legal-social hildes-social-pills hildes-social-pills--legal-strip" aria-label="Social links">
                                <li><a href="{{ $contact->github ?: '#' }}" @if($contact->github) target="_blank" rel="noopener noreferrer" @endif aria-label="GitHub"><i class="fab fa-github"></i></a></li>
                                <li><a href="{{ $contact->linkedin ?: '#' }}" @if($contact->linkedin) target="_blank" rel="noopener noreferrer" @endif aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a class="mr--0" href="{{ $contact->facebook ?: '#' }}" @if($contact->facebook) target="_blank" rel="noopener noreferrer" @endif aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- copyright area end -->
        <div class="rts-copyright-area text-center">
            <img class="hildes-footer-big-logo" src="{{ asset('assets/images/logo/logo-footer-big.png') }}" alt="HilDes" loading="lazy" decoding="async">
        </div>
    </div>
    <!-- <div class="rts-footer-area footer-two mt-dec-footer-map bg-footer-two bg_image"> -->
    <!-- </div> -->
    <!-- rts footer two area wrapper end -->

    <div id="side-bar" class="side-bar header-two">
    <button class="close-icon-menu" title="Close menu"><i class="far fa-times"></i></button>
    <!-- inner menu area desktop start -->
    <div class="rts-sidebar-menu-desktop">
        <a class="logo-1" href="/"><img class="logo mt-0" src="{{ asset('assets/images/logo/logo.png') }}" alt="HilDes"><span class="hildes-brand-text">HilDes</span></a>
        <div class="body d-none d-xl-block">
            <p class="disc">
                HilDes focuses on AI solutions, SaaS product engineering, and rapid MVP development
                to help startups and growing businesses launch, validate, and scale faster.
            </p>
            <div class="get-in-touch">
                <!-- title -->
                <div class="h6 title">Get In Touch</div>
                <!-- title End -->
                <div class="wrapper">
                    <!-- single -->
                    @if(filled($contact->email))
                    <div class="single">
                        <i class="fas fa-envelope"></i>
                        <a href="{{ $contact->mailtoHref() }}">{{ $contact->email }}</a>
                    </div>
                    @endif
                    @if(filled($contact->whatsapp))
                    <div class="single">
                        <i class="fab fa-whatsapp"></i>
                        <a href="{{ $contact->whatsappHref() }}" target="_blank" rel="noopener noreferrer">{{ $contact->whatsapp }}</a>
                    </div>
                    @endif
                    @if(filled($contact->phone))
                    <div class="single">
                        <i class="fas fa-phone-alt"></i>
                        <a href="{{ $contact->telHref() }}">{{ $contact->phone }}</a>
                    </div>
                    @endif
                    @if(filled($contact->address_line))
                    <div class="single">
                        <i class="fas fa-map-marker-alt"></i>
                        <a href="{{ filled($contact->google_map_url) ? $contact->google_map_url : '#' }}" @if(filled($contact->google_map_url)) target="_blank" rel="noopener noreferrer" @endif>{{ $contact->address_line }}</a>
                    </div>
                    @endif
                </div>
                <div class="social-wrapper-two menu">
                    <a href="{{ $contact->github ?: '#' }}" @if($contact->github) target="_blank" rel="noopener noreferrer" @endif aria-label="GitHub"><i class="fab fa-github"></i></a>
                    <a href="{{ $contact->linkedin ?: '#' }}" @if($contact->linkedin) target="_blank" rel="noopener noreferrer" @endif aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{ $contact->facebook ?: '#' }}" @if($contact->facebook) target="_blank" rel="noopener noreferrer" @endif aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- mobile menu area start -->
    <div class="mobile-menu d-block d-xl-none">
        <nav class="nav-main mainmenu-nav mt--30">
            <ul class="mainmenu metismenu" id="mobile-menu-active">
                <li>
                    <a href="{{ route('home') }}" class="main" aria-expanded="false">Home</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="main" aria-expanded="false">About Us</a>
                </li>
                <li class="has-droupdown">
                    <a href="#" class="main" aria-expanded="false">Services</a>
                    <ul class="submenu mm-collapse hildes-mobile-submenu">
                        @php($mobileServices = collect($headerServices ?? [])->values())
                        @foreach($mobileServices as $serviceItem)
                            <li>
                                <a class="mobile-menu-link hildes-mobile-submenu-link" href="{{ route('service.slug', $serviceItem->slug) }}">
                                    <i class="fa-solid fa-chevron-right hildes-mobile-submenu-chevron" aria-hidden="true"></i>
                                    <span class="hildes-mobile-submenu-label">{{ $serviceItem->name }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a class="mobile-menu-link hildes-mobile-submenu-link" href="{{ route('services.index') }}">
                                <i class="fa-solid fa-chevron-right hildes-mobile-submenu-chevron" aria-hidden="true"></i>
                                <span class="hildes-mobile-submenu-label">All Services</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="has-droupdown">
                    <a href="#" class="main" aria-expanded="false">Case Studies</a>
                    <ul class="submenu mm-collapse hildes-mobile-submenu">
                        @php($mobileCaseStudies = collect($headerCaseStudies ?? [])->values())
                        @foreach($mobileCaseStudies as $caseStudyItem)
                            <li>
                                <a class="mobile-menu-link hildes-mobile-submenu-link" href="{{ route('case-studies.show', $caseStudyItem->slug) }}">
                                    <i class="fa-solid fa-chevron-right hildes-mobile-submenu-chevron" aria-hidden="true"></i>
                                    <span class="hildes-mobile-submenu-label">{{ $caseStudyItem->title }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a class="mobile-menu-link hildes-mobile-submenu-link" href="{{ route('case-studies.index') }}">
                                <i class="fa-solid fa-chevron-right hildes-mobile-submenu-chevron" aria-hidden="true"></i>
                                <span class="hildes-mobile-submenu-label">All Case Studies</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- career -->
                <li>
                    <a href="{{ route('careers.page') }}" class="main" aria-expanded="false">Careers</a>
                </li>
                <li>
                    <a href="{{ route('faqs.page') }}" class="main" aria-expanded="false">FAQs</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="main" aria-expanded="false">Contact Us</a>
                </li>
                <li>
                    <a href="{{ route('quote') }}" class="main" aria-expanded="false">Get a Quote</a>
                </li>
                <li>
                    <a href="{{ route('why-us.page') }}" class="main" aria-expanded="false">Why Us</a>
                </li>
                <li>
                    <a href="{{ route('privacy.page') }}" class="main" aria-expanded="false">Privacy Policy</a>
                </li>
                <li>
                    <a href="{{ route('terms.page') }}" class="main" aria-expanded="false">Terms &amp; Conditions</a>
                </li>
                <li>
                    <a href="{{ route('sla.page') }}" class="main" aria-expanded="false">SLA</a>
                </li>
            </ul>
        </nav>

        <div class="social-wrapper-one">
            <ul>
                <li>
                    <a href="{{ $contact->github ?: '#' }}" @if($contact->github) target="_blank" rel="noopener noreferrer" @endif aria-label="GitHub">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ $contact->linkedin ?: '#' }}" @if($contact->linkedin) target="_blank" rel="noopener noreferrer" @endif aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ $contact->facebook ?: '#' }}" @if($contact->facebook) target="_blank" rel="noopener noreferrer" @endif aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- mobile menu area end -->
</div>
<!-- inner menu area desktop End -->


<!-- offcanvase search -->
<div class="search-input-area">
    <div class="container">
        <div class="search-input-inner">
            <div class="input-div">
                <input class="search-input autocomplete" id="site-search-input" type="text" placeholder="Search by keyword or #" autocomplete="off">
                <button type="button" aria-label="Search"><i class="far fa-search"></i></button>
                <div id="site-search-suggestions" class="hildes-search-suggestions" role="listbox" aria-label="Search suggestions"></div>
            </div>
        </div>
    </div>
    <div id="close" class="search-close-icon"><i class="far fa-times"></i></div>
</div>
<script id="site-search-data" type="application/json">@json($searchItems ?? [])</script>
<div id="anywhere-home" class="">
</div>

<div class="hildes-floating-actions" aria-label="Quick contact actions">
    @foreach($quickActions ?? [] as $action)
        @if($action['show'])
            <a href="{{ $action['href'] }}"
               class="hildes-floating-action {{ $action['extraClass'] }}"
               aria-label="{{ $action['label'] }}"
               title="{{ $action['label'] }}"
               @if($action['target']) target="{{ $action['target'] }}" @endif
               @if($action['rel']) rel="{{ $action['rel'] }}" @endif>
                <i class="{{ $action['icon'] }}"></i>
            </a>
        @endif
    @endforeach
</div>

<!-- progress area start -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
            style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
        </path>
    </svg>
</div>
<!-- progress area end -->

<div id="hildes-ajax-toast" class="hildes-job-apply-toast" role="status" aria-live="polite" hidden></div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof fetch !== 'function') return;

    var toast = document.getElementById('hildes-ajax-toast');
    var toastTimer = null;

    function showToast(message, isError) {
        if (!toast) return;
        if (toastTimer) clearTimeout(toastTimer);
        toast.hidden = false;
        toast.textContent = message || '';
        toast.classList.toggle('hildes-job-apply-toast--error', !!isError);
        toast.classList.add('hildes-job-apply-toast--visible');
        toastTimer = setTimeout(function () {
            toast.classList.remove('hildes-job-apply-toast--visible');
            setTimeout(function () {
                toast.hidden = true;
                toast.textContent = '';
            }, 320);
        }, 5200);
    }

    function wireAjaxForm(form, config) {
        if (!form || form.dataset.ajaxWired === '1') return;
        form.dataset.ajaxWired = '1';

        var submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;
        var btnText = submitBtn.querySelector('.hildes-ajax-btn-text');
        var defaultLabel = submitBtn.getAttribute('data-submit-label') || (btnText ? btnText.textContent : 'Submit');
        var defaultHtml = btnText ? btnText.innerHTML : '';
        var statusEl = form.parentElement ? form.parentElement.querySelector('[data-form-status]') : null;
        if (!statusEl) {
            statusEl = form.querySelector('[data-form-status]');
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (statusEl) statusEl.textContent = 'Please wait 3-5 seconds...';
            submitBtn.disabled = true;
            submitBtn.classList.add('is-loading');
            if (btnText && !btnText.querySelector('i')) {
                btnText.textContent = 'Please wait...';
            }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(function (res) {
                return res.text().then(function (text) {
                    var data = {};
                    try { data = text ? JSON.parse(text) : {}; } catch (_e) {}
                    return { ok: res.ok, status: res.status, data: data };
                });
            })
            .then(function (result) {
                if (result.ok && result.data && result.data.success) {
                    if (statusEl) statusEl.textContent = config.successStatus;
                    showToast(result.data.message || config.successStatus, false);
                    form.reset();
                    return;
                }
                if (result.status === 422) {
                    if (statusEl) statusEl.textContent = 'Please check your details and try again.';
                    showToast((result.data && result.data.message) || 'Please check your details and try again.', true);
                    return;
                }
                if (statusEl) statusEl.textContent = config.errorStatus;
                showToast((result.data && result.data.message) || config.errorStatus, true);
            })
            .catch(function () {
                if (statusEl) statusEl.textContent = config.errorStatus;
                showToast(config.errorStatus, true);
            })
            .finally(function () {
                submitBtn.disabled = false;
                submitBtn.classList.remove('is-loading');
                if (btnText) {
                    if (defaultHtml && defaultHtml.indexOf('<') !== -1) {
                        btnText.innerHTML = defaultHtml;
                    } else {
                        btnText.textContent = defaultLabel;
                    }
                }
            });
        });
    }

    document.querySelectorAll('form[data-ajax-lead-form]').forEach(function (form) {
        wireAjaxForm(form, {
            successStatus: 'Submitted successfully. Our team will contact you soon.',
            errorStatus: 'Something went wrong. Please try again.'
        });
    });

    document.querySelectorAll('form[data-ajax-newsletter-form]').forEach(function (form) {
        wireAjaxForm(form, {
            successStatus: 'Subscribed successfully.',
            errorStatus: 'Unable to subscribe right now. Please try again.'
        });
    });
});
</script>
@endpush
