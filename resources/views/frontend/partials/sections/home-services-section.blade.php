<!-- rts service area start -->
<div class="rts-service-area pt--40 pb--60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-style-two center">
                    <span class="bg-content">Services</span>
                    <span class="pre">our Services</span>
                    <h2 class="title rts-text-anime-style-1">High Quality Services
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container-2 mt--30">
        <div class="row">
            <div class="col-lg-12">
                <div class="service-bg-style-one-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="service-style-swiper-wrapper-two">
                                <div class="swiper mySwiper-service-1">
                                    <div class="swiper-wrapper">
                                        @forelse(collect($headerServices ?? []) as $serviceItem)
                                            @php($n = strtolower((string) $serviceItem->name))
                                            @php($icon = match (true) {
                                                str_contains($n, 'mobile') => 'fa-solid fa-mobile-screen-button',
                                                str_contains($n, 'saas') => 'fa-solid fa-cloud',
                                                str_contains($n, 'mvp') => 'fa-solid fa-rocket',
                                                str_contains($n, 'e-commerce') || str_contains($n, 'ecommerce') || str_contains($n, 'commerce') => 'fa-solid fa-cart-shopping',
                                                str_contains($n, 'ui') || str_contains($n, 'ux') => 'fa-solid fa-pen-ruler',
                                                str_contains($n, 'api') => 'fa-solid fa-plug',
                                                str_contains($n, 'cloud') || str_contains($n, 'devops') => 'fa-solid fa-server',
                                                str_contains($n, 'ai') || str_contains($n, 'automation') => 'fa-solid fa-robot',
                                                str_contains($n, 'rescue') || str_contains($n, 'scaling') => 'fa-solid fa-life-ring',
                                                str_contains($n, 'web') => 'fa-solid fa-code',
                                                default => 'fa-solid fa-diagram-project',
                                            })
                                            <div class="swiper-slide">
                                                <div class="single-service-signle-wrapper">
                                                    <div class="icons hildes-home-service-slider-icon">
                                                        <i class="{{ $icon }}" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="information">
                                                        <h5 class="title">{{ $serviceItem->name }}</h5>
                                                        <p class="disc">
                                                            {{ \Illuminate\Support\Str::limit(strip_tags((string) $serviceItem->hero_headline), 140) }}
                                                        </p>
                                                        <a href="{{ route('service.slug', $serviceItem->slug) }}" class="arrow-right">
                                                            <i class="fa-sharp fa-solid fa-arrow-right"></i>
                                                            <span>Read More</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="swiper-slide">
                                                <div class="single-service-signle-wrapper">
                                                    <div class="icons hildes-home-service-slider-icon">
                                                        <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="information">
                                                        <h5 class="title">Services</h5>
                                                        <p class="disc">Browse all HilDes services.</p>
                                                        <a href="{{ route('services.index') }}" class="arrow-right">
                                                            <i class="fa-sharp fa-solid fa-arrow-right"></i>
                                                            <span>Read More</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- rts service area end -->
