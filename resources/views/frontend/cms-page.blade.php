@extends('frontend.layouts.app')

@section('content')
    <div class="rts-breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-left">
                        <span class="pre">{{ $cmsHeroPre }}</span>
                        <span class="bg-title">{{ $cmsHeroBgTitle }}</span>
                        <h1 class="title rts-text-anime-style-1">{!! $cmsHeroTitle !!}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(filled($cmsPage->banner_image_url ?? null))
        <div class="about-invena-large-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="large-image-bottm-breadcrumb">
                            <img src="{{ $cmsPage->banner_image_url }}" alt="{{ $cmsPage->banner_image_alt ?: $cmsPage->title }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(filled($cmsPage->detail_content ?? null))
        <section class="hildes-services-cms-detail cms-page-detail-block mb--310">
            <div class="container">
                <div class="hildes-services-cms-card">
                    {!! $cmsPage->detail_content !!}
                </div>
            </div>
        </section>
    @endif

    @if(($cmsFaqs ?? collect())->isNotEmpty())
        <section class="rts-section-gapBottom mb--310">
            <div class="container">
                <div class="service-section-card service-section-card--b service-faq-section">
                    <h3 class="title">Popular Questions</h3>
                    <div class="accordion faq-wrapper-inner-page mt--20" id="accordionCmsPageFaq">
                        @foreach($cmsFaqs as $index => $faq)
                            @php($collapseId = 'cmsPageFaqCollapse' . $index)
                            @php($headingId = 'cmsPageFaqHeading' . $index)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                    </button>
                                </h2>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionCmsPageFaq">
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
