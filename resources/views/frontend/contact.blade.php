@extends('frontend.layouts.app')

@php
    $contact = $contact ?? \App\Models\ContactSetting::query()->firstOrCreate([]);
    $isCareerResumeFlow = request()->query('from') === 'careers';
@endphp

@section('content')
    <div class="contact-page-view">
        @include('frontend.partials.sections.page-hero', [
            'pre' => 'Get In Touch',
            'bgTitle' => 'Contact',
            'title' => 'Contact Us',
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
                        <form class="form__content" method="POST" action="{{ route('lead-submissions.store') }}" data-ajax-lead-form enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="source" value="{{ $isCareerResumeFlow ? 'career_resume' : 'contact' }}">
                            <h4 class="title">Get In Touch</h4>
                            <input name="full_name" type="text" value="{{ old('full_name') }}" placeholder="Full Name" autocomplete="name">
                            <input name="company_name" type="text" value="{{ old('company_name') }}" placeholder="Company Name" autocomplete="organization">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="email">
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone / WhatsApp" autocomplete="tel">
                            <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject">
                            <textarea name="message" placeholder="Tell us about your project requirements">{{ old('message') }}</textarea>
                            @if($isCareerResumeFlow)
                                <div class="hildes-careers-resume-dropzone-wrap">
                                    <div class="job-apply-dropzone" data-careers-resume-dropzone>
                                        <input id="contact-resume-file" class="job-apply-dropzone__input-native" type="file" name="resume_file" accept=".pdf,.doc,.docx,application/pdf" required>
                                        <label for="contact-resume-file" class="job-apply-dropzone__label-hit">
                                            <span class="job-apply-dropzone__ui">
                                                <span class="job-apply-dropzone__icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                                                <span class="job-apply-dropzone__line"><strong>Click to upload</strong> or drag and drop</span>
                                                <span class="job-apply-dropzone__hint">Resume (PDF, DOC, DOCX) · max 5MB</span>
                                                <span class="job-apply-dropzone__name" data-careers-resume-filename hidden></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <p class="hildes-ajax-form-status" data-form-status aria-live="polite"></p>
                            <button class="rts-btn btn-primary" type="submit" data-submit-label="Send Message"><span class="hildes-ajax-btn-text">Send Message</span></button>
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

        @if(($contactCmsFaqs ?? collect())->isNotEmpty())
            <section class="rts-section-gapTop hildes-services-faq-block contact-page-last-section">
                <div class="container">
                    <div class="service-section-card service-section-card--b service-faq-section">
                        <h3 class="title">Popular Questions</h3>
                        <div class="accordion faq-wrapper-inner-page mt--20" id="accordionContactPageFaq">
                            @foreach($contactCmsFaqs as $index => $faq)
                                @php($collapseId = 'contactPageFaqCollapse' . $index)
                                @php($headingId = 'contactPageFaqHeading' . $index)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="{{ $headingId }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                            {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                        </button>
                                    </h2>
                                    <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionContactPageFaq">
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

@if($isCareerResumeFlow)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var form = document.querySelector('form[data-ajax-lead-form]');
                if (!form) return;
                var input = form.querySelector('#contact-resume-file');
                var dropzone = form.querySelector('[data-careers-resume-dropzone]');
                var fileNameEl = form.querySelector('[data-careers-resume-filename]');
                if (!input || !dropzone || !fileNameEl) return;

                function updateFileName() {
                    var file = input.files && input.files[0];
                    if (file) {
                        fileNameEl.textContent = file.name;
                        fileNameEl.hidden = false;
                    } else {
                        fileNameEl.textContent = '';
                        fileNameEl.hidden = true;
                    }
                }

                input.addEventListener('change', updateFileName);
                form.addEventListener('reset', function () {
                    setTimeout(function () {
                        dropzone.classList.remove('job-apply-dropzone--active');
                        updateFileName();
                    }, 0);
                });

                ['dragenter', 'dragover'].forEach(function (eventName) {
                    dropzone.addEventListener(eventName, function (event) {
                        event.preventDefault();
                        dropzone.classList.add('job-apply-dropzone--active');
                    });
                });

                ['dragleave', 'drop'].forEach(function (eventName) {
                    dropzone.addEventListener(eventName, function (event) {
                        event.preventDefault();
                        dropzone.classList.remove('job-apply-dropzone--active');
                    });
                });

                dropzone.addEventListener('drop', function (event) {
                    var files = event.dataTransfer && event.dataTransfer.files;
                    if (!files || !files.length) return;
                    input.files = files;
                    updateFileName();
                });
            });
        </script>
    @endpush
@endif
