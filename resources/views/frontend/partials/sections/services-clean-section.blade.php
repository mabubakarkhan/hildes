@php
    $servicesForSection = \App\Models\ServicePage::query()
        ->where('is_published', true)
        ->ordered()
        ->get(['id', 'name', 'slug', 'hero_headline', 'general_image', 'general_image_alt']);
@endphp

<div class="our-service-area-start rts-section-gapBottom pt--40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-style-two center">
                    <span class="bg-content">Services</span>
                    <span class="pre">our Services</span>
                    <h2 class="title rts-text-anime-style-1">High Quality Services</h2>
                </div>
            </div>
        </div>
        <div class="row mt--30">
            <div class="col-lg-12">
                <div class="rts-service-main-wrapper-10">
                    @forelse($servicesForSection as $service)
                        @php($reverseRow = ((int) floor($loop->index / 2)) % 2 === 1)
                        <div class="signle-service-style-10 {{ $reverseRow ? 'order-control-sm-device' : '' }}">
                            @if($reverseRow)
                                <a class="thumbnail" href="{{ route('service.slug', $service->slug) }}">
                                    <img loading="lazy" src="{{ $service->general_image_url ?: asset('assets/images/service/07.webp') }}" alt="{{ $service->general_image_alt ?: $service->name }}">
                                </a>
                            @endif
                            <div class="content-area-wrapper">
                                <h5 class="title">{{ $service->name }}</h5>
                                <p class="disc">{{ \Illuminate\Support\Str::limit(strip_tags((string) $service->hero_headline), 90) }}</p>
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
