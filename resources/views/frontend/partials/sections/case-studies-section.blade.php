@php
    $caseStudiesForSection = collect($headerCaseStudies ?? []);
    if ($caseStudiesForSection->isEmpty()) {
        $caseStudiesForSection = \App\Models\CaseStudy::query()
            ->where('is_published', true)
            ->ordered()
            ->get(['id', 'title', 'slug', 'tagline', 'featured_image', 'featured_image_alt']);
    }
@endphp

<!-- start gallery section -->
<div class="rts-gallery-area rts-section-gap gallery-bg bg_image">
    <div class="container pt--40">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between-wrapper-gallery-project">
                    <div class="title-style-two mb--40 left">
                        <span class="bg-content">Case Studies</span>
                        <span class="pre">Case Studies</span>
                        <h2 class="title rts-text-anime-style-1">Success Stories</h2>
                    </div>

                    <div class="swiper-paginations"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="project-style-one-wrapper">

                    <div class="swiper mySwiper-project-1">
                        <div class="swiper-wrapper">
                            @forelse($caseStudiesForSection as $caseStudyItem)
                                <div class="swiper-slide">
                                    <article class="case-study-index-card">
                                        <a href="{{ route('case-studies.show', $caseStudyItem->slug) }}" class="thumbnail">
                                            <img loading="lazy" src="{{ $caseStudyItem->featured_image_url ?: asset('assets/images/project/01.webp') }}" alt="{{ $caseStudyItem->featured_image_alt ?: $caseStudyItem->title }}">
                                        </a>
                                        <div class="case-study-index-content">
                                            <h5 class="title">
                                                <a href="{{ route('case-studies.show', $caseStudyItem->slug) }}">{{ $caseStudyItem->title }}</a>
                                            </h5>
                                            @if(filled($caseStudyItem->tagline))
                                                <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $caseStudyItem->tagline), 120) }}</p>
                                            @endif
                                            <a href="{{ route('case-studies.show', $caseStudyItem->slug) }}" class="arrow-right-btn">Read More <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </article>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <div class="project-style-one">
                                        <a href="{{ url('/') }}" class="thumbnail">
                                            <img loading="lazy" src="{{ asset('assets/images/project/01.webp') }}" alt="">
                                        </a>
                                        <div class="inner-content">
                                            <a href="{{ url('/') }}">
                                                <h5 class="title">Case studies</h5>
                                            </a>
                                            <span>Coming soon</span>
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
<!-- start gallery section -->
