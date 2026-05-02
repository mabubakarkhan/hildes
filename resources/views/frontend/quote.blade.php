@extends('frontend.layouts.app')

@php
    $contact = $contact ?? \App\Models\ContactSetting::query()->firstOrCreate([]);
@endphp

@section('content')
    <div class="contact-page-view">
        @include('frontend.partials.sections.page-hero', [
            'pre' => 'Project Estimate',
            'bgTitle' => 'Quote',
            'title' => 'Get a Quote',
        ])

        <div class="rts-contact-area-in-page" data-animation="fadeInUp" data-delay="0.2">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-4">
                        <div class="contact-info-area-wrapper-p">
                            @if(filled($contact->email))
                                <div class="single-contact-info">
                                    <div class="icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div class="info-wrapper">
                                        <span>Work with us</span>
                                        <a href="{{ $contact->mailtoHref() }}">{{ $contact->email }}</a>
                                    </div>
                                </div>
                            @endif
                            @if(filled($contact->whatsapp))
                                <div class="single-contact-info">
                                    <div class="icon">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div class="info-wrapper">
                                        <span>WhatsApp</span>
                                        <a href="{{ $contact->whatsappHref() }}" target="_blank" rel="noopener noreferrer">{{ $contact->whatsapp }}</a>
                                    </div>
                                </div>
                            @endif
                            @if(filled($contact->phone))
                                <div class="single-contact-info">
                                    <div class="icon">
                                        <i class="fa-solid fa-phone-flip"></i>
                                    </div>
                                    <div class="info-wrapper">
                                        <span>Call Us</span>
                                        <a href="{{ $contact->telHref() }}">{{ $contact->phone }}</a>
                                    </div>
                                </div>
                            @endif
                            @if(filled($contact->address_line))
                                <div class="single-contact-info">
                                    <div class="icon">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div class="info-wrapper">
                                        <span>Our Location</span>
                                        <a href="{{ filled($contact->google_map_url) ? $contact->google_map_url : '#' }}" @if(filled($contact->google_map_url)) target="_blank" rel="noopener noreferrer" @endif>{{ $contact->address_line }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-form-p">
                            <form class="form__content" method="POST" action="{{ route('lead-submissions.store') }}" data-ajax-lead-form>
                                @csrf
                                <input type="hidden" name="source" value="quote">
                                <h4 class="title">Request a Quote</h4>
                                <input name="full_name" type="text" value="{{ old('full_name') }}" placeholder="Full Name" autocomplete="name">
                                <input name="company_name" type="text" value="{{ old('company_name') }}" placeholder="Company Name" autocomplete="organization">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="email">
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone / WhatsApp" autocomplete="tel">
                                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Project Type / Subject">
                                <textarea name="message" placeholder="Tell us about your scope, timeline, and budget">{{ old('message') }}</textarea>
                                <p class="hildes-ajax-form-status" data-form-status aria-live="polite"></p>
                                <button class="rts-btn btn-primary" type="submit" data-submit-label="Request Quote"><span class="hildes-ajax-btn-text">Request Quote</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(filled($contact->google_map_url))
            <div class="google-map-area rts-section-gapTop">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="google-map">
                                <iframe
                                    src="{{ $contact->google_map_url }}"
                                    width="600"
                                    height="600"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(($quoteCmsFaqs ?? collect())->isNotEmpty())
            <section class="rts-section-gapTop hildes-services-faq-block contact-page-last-section">
                <div class="container">
                    <div class="service-section-card service-section-card--b service-faq-section">
                        <h3 class="title">Popular Questions</h3>
                        <div class="accordion faq-wrapper-inner-page mt--20" id="accordionQuotePageFaq">
                            @foreach($quoteCmsFaqs as $index => $faq)
                                @php($collapseId = 'quotePageFaqCollapse' . $index)
                                @php($headingId = 'quotePageFaqHeading' . $index)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="{{ $headingId }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                            {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                        </button>
                                    </h2>
                                    <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionQuotePageFaq">
                                        <div class="accordion-body">{!! data_get($faq, 'detail') !!}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
