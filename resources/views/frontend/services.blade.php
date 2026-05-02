@extends('frontend.layouts.app')

@section('content')
    @include('frontend.partials.sections.page-hero', [
        'pre' => 'Our Services',
        'bgTitle' => 'Our Services',
        'title' => 'Services We Provide',
    ])

    <div class="our-service-area-start rts-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="rts-service-main-wrapper-10">
                        @forelse($services as $service)
                            @php($reverseRow = ((int) floor($loop->index / 2)) % 2 === 1)
                            <div class="signle-service-style-10 {{ $reverseRow ? 'order-control-sm-device' : '' }}">
                                @if($reverseRow)
                                    <a class="thumbnail" href="{{ route('service.slug', $service->slug) }}">
                                        <img loading="lazy" src="{{ $service->general_image_url ?: asset('assets/images/service/07.webp') }}" alt="{{ $service->general_image_alt ?: $service->name }}">
                                    </a>
                                @endif
                                <div class="content-area-wrapper">
                                    <h5 class="title">{{ $service->name }}</h5>
                                    <p class="disc">{{ \Illuminate\Support\Str::limit(strip_tags((string) $service->hero_headline), 80) }}</p>
                                    <a href="{{ route('service.slug', $service->slug) }}" class="arrow-right-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                                @unless($reverseRow)
                                    <a class="thumbnail" href="{{ route('service.slug', $service->slug) }}">
                                        <img loading="lazy" src="{{ $service->general_image_url ?: asset('assets/images/service/07.webp') }}" alt="{{ $service->general_image_alt ?: $service->name }}">
                                    </a>
                                @endunless
                            </div>
                        @empty
                            <div class="signle-service-style-10">
                                <div class="content-area-wrapper">
                                    <h5 class="title">No services available yet.</h5>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(($servicesCmsFaqs ?? collect())->isNotEmpty())
        <section class="rts-section-gapBottom hildes-services-faq-block">
            <div class="container">
                <div class="service-section-card service-section-card--b service-faq-section">
                    <h3 class="title">Popular Questions</h3>
                    <div class="accordion faq-wrapper-inner-page mt--20" id="accordionServicesPageFaq">
                        @foreach($servicesCmsFaqs as $index => $faq)
                            @php($collapseId = 'servicesPageFaqCollapse' . $index)
                            @php($headingId = 'servicesPageFaqHeading' . $index)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                    </button>
                                </h2>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionServicesPageFaq">
                                    <div class="accordion-body">{!! data_get($faq, 'detail') !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if(filled($servicesCmsDetail ?? null))
        <section class="hildes-services-cms-detail mb--310">
            <div class="container">
                <div class="hildes-services-cms-card">
                    {!! $servicesCmsDetail !!}
                </div>
            </div>
        </section>
    @endif
@endsection
