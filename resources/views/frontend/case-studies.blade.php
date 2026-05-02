@extends('frontend.layouts.app')

@section('content')
    @include('frontend.partials.sections.page-hero', [
        'pre' => 'Our Case Studies',
        'bgTitle' => 'Our Case Studies',
        'title' => 'Case Studies & Success Stories',
    ])

    <div class="case-studies-index-section rts-section-gapBottom">
        <div class="container">
            <div class="row g-4">
                @forelse($caseStudies as $caseStudy)
                    <div class="col-lg-6 col-md-6">
                        <article class="case-study-index-card">
                            <a href="{{ route('case-studies.show', $caseStudy->slug) }}" class="thumbnail">
                                <img loading="lazy" src="{{ $caseStudy->featured_image_url ?: asset('assets/images/project/01.webp') }}" alt="{{ $caseStudy->featured_image_alt ?: $caseStudy->title }}">
                            </a>
                            <div class="case-study-index-content">
                                <h5 class="title">
                                    <a href="{{ route('case-studies.show', $caseStudy->slug) }}">{{ $caseStudy->title }}</a>
                                </h5>
                                @if(filled($caseStudy->tagline))
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $caseStudy->tagline), 120) }}</p>
                                @endif
                                <a href="{{ route('case-studies.show', $caseStudy->slug) }}" class="arrow-right-btn">Read More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <article class="case-study-index-card">
                            <div class="case-study-index-content">
                                <h5 class="title">No case studies available yet.</h5>
                            </div>
                        </article>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @if(($caseStudiesCmsFaqs ?? collect())->isNotEmpty())
        <section class="rts-section-gapBottom hildes-services-faq-block">
            <div class="container">
                <div class="service-section-card service-section-card--b service-faq-section">
                    <h3 class="title">Popular Questions</h3>
                    <div class="accordion faq-wrapper-inner-page mt--20" id="accordionCaseStudiesPageFaq">
                        @foreach($caseStudiesCmsFaqs as $index => $faq)
                            @php($collapseId = 'caseStudiesPageFaqCollapse' . $index)
                            @php($headingId = 'caseStudiesPageFaqHeading' . $index)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                    </button>
                                </h2>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionCaseStudiesPageFaq">
                                    <div class="accordion-body">{!! data_get($faq, 'detail') !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if(filled($caseStudiesCmsDetail ?? null))
        <section class="hildes-services-cms-detail mb--310">
            <div class="container">
                <div class="hildes-services-cms-card">
                    {!! $caseStudiesCmsDetail !!}
                </div>
            </div>
        </section>
    @endif
@endsection
