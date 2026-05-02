@php
    $pre = $pre ?? '';
    $bgTitle = $bgTitle ?? '';
    $title = $title ?? '';
@endphp

<div class="rts-breadcrumb-area small-h">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-left center">
                    <span class="pre">{{ $pre }}</span>
                    <span class="bg-title">{{ $bgTitle }}</span>
                    <h1 class="title rts-text-anime-style-1">{{ $title }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-area">
        <img src="{{ asset('assets/images/about/shape/01.png') }}" alt="" class="one" loading="lazy">
        <img src="{{ asset('assets/images/about/shape/02.png') }}" alt="" class="two" loading="lazy">
        <img src="{{ asset('assets/images/about/shape/03.png') }}" alt="" class="three" loading="lazy">
    </div>
</div>
