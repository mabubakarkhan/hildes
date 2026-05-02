@extends('frontend.layouts.app')

@section('content')
    <div class="rts-breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-left">
                        <span class="pre">About HilDes</span>
                        <span class="bg-title">About Us</span>
                        <h1 class="title rts-text-anime-style-1">
                            AI, SaaS and MVP <br>
                            product experts.
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about-invena-large-image">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="large-image-bottm-breadcrumb">
                        <img src="{{ asset('assets/images/banner/21.webp') }}" alt="HilDes About">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.partials.sections.about-talent-section')
    @include('frontend.partials.sections.hildes-grow-business-cta')
    @if(filled($aboutDetailIntro ?? null) || ($aboutDetailSections ?? collect())->isNotEmpty())
        <section class="about-page-db-detail">
            <div class="container">
                @if(filled($aboutDetailTitle ?? null))
                    <div class="title-style-two center mb--30">
                        <span class="bg-content">About</span>
                        <span class="pre">Company Profile</span>
                        <h2 class="title rts-text-anime-style-1">{{ $aboutDetailTitle }}</h2>
                    </div>
                @endif

                @if(filled($aboutDetailIntro ?? null))
                    <div class="about-page-db-intro">
                        {!! $aboutDetailIntro !!}
                    </div>
                @endif

                @if(($aboutDetailSections ?? collect())->isNotEmpty())
                    <div class="about-page-db-grid">
                        @foreach($aboutDetailSections as $section)
                            @php($headingText = (string) data_get($section, 'heading'))
                            @php($sectionKey = \Illuminate\Support\Str::slug($headingText))
                            @php($iconClass = match ($sectionKey) {
                                'our-expertise' => 'fa-solid fa-brain',
                                'our-approach-to-building-software' => 'fa-solid fa-diagram-project',
                                'why-businesses-choose-hildes' => 'fa-solid fa-circle-check',
                                'our-vision' => 'fa-solid fa-eye',
                                'work-with-us' => 'fa-solid fa-handshake',
                                default => 'fa-solid fa-star',
                            })
                            @if($sectionKey === 'work-with-us')
                                <article class="about-page-db-cta">
                                    <div class="about-page-db-cta-left">
                                        <span class="about-page-db-icon"><i class="{{ $iconClass }}"></i></span>
                                        <div>
                                            <h3>{{ $headingText }}</h3>
                                            <div class="about-page-db-card-content">{!! data_get($section, 'body') !!}</div>
                                        </div>
                                    </div>
                                    <div class="about-page-db-cta-actions">
                                        <a href="{{ route('quote') }}" class="rts-btn btn-primary">Let's Build Together</a>
                                        <a href="{{ route('contact') }}" class="rts-btn btn-border">Book a Consultation</a>
                                    </div>
                                </article>
                            @else
                                <article class="about-page-db-card about-page-db-card--{{ $sectionKey }}">
                                    <div class="about-page-db-card-top">
                                        <h3>{{ $headingText }}</h3>
                                        <span class="about-page-db-icon"><i class="{{ $iconClass }}"></i></span>
                                    </div>
                                    <div class="about-page-db-card-content">
                                        {!! data_get($section, 'body') !!}
                                    </div>
                                </article>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif
    @include('frontend.partials.sections.services-clean-section')
    <div class="about-page-case-studies-gap">
        @include('frontend.partials.sections.case-studies-section')
    </div>
    @if(($aboutCmsFaqs ?? collect())->isNotEmpty())
        <section class="rts-section-gapBottom hildes-services-faq-block about-page-faq-block">
            <div class="container">
                <div class="service-section-card service-section-card--b service-faq-section">
                    <h3 class="title">Popular Questions</h3>
                    <div class="accordion faq-wrapper-inner-page mt--20" id="accordionAboutPageFaq">
                        @foreach($aboutCmsFaqs as $index => $faq)
                            @php($collapseId = 'aboutPageFaqCollapse' . $index)
                            @php($headingId = 'aboutPageFaqHeading' . $index)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                    </button>
                                </h2>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionAboutPageFaq">
                                    <div class="accordion-body">{!! data_get($faq, 'detail') !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

