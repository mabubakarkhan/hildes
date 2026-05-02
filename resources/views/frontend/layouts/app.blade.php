<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="{{ $metaViewport ?? 'width=device-width, initial-scale=1.0' }}">
    <title>{{ $metaTitle ?? 'HilDes - Technology Services' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'HilDes is a technology services company specializing in web, mobile, AI, digital marketing, SEO, and graphics.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'HilDes, web development, mobile app development, AI services, digital marketing, SEO, graphics' }}">
    <meta name="author" content="{{ $metaAuthor ?? 'HilDes' }}">
    <meta name="robots" content="{{ $metaRobots ?? 'index,follow' }}">
    <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $ogTitle ?? ($metaTitle ?? 'HilDes - Technology Services') }}">
    <meta property="og:description" content="{{ $ogDescription ?? ($metaDescription ?? 'HilDes technology and digital services.') }}">
    <meta property="og:url" content="{{ $ogUrl ?? ($canonicalUrl ?? url()->current()) }}">
    <meta property="og:site_name" content="{{ $ogSiteName ?? 'HilDes' }}">
    @if(!empty($ogImage))
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    <meta name="twitter:card" content="{{ $twitterCard ?? 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $twitterTitle ?? ($metaTitle ?? 'HilDes - Technology Services') }}">
    <meta name="twitter:description" content="{{ $twitterDescription ?? ($metaDescription ?? 'HilDes technology and digital services.') }}">
    @if(!empty($twitterImage))
        <meta name="twitter:image" content="{{ $twitterImage }}">
    @endif
    @if(filled($schemaJson ?? null))
        <script type="application/ld+json">{!! $schemaJson !!}</script>
    @endif

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/fav.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/metismenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnifying-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/theme-lazy.css') }}">
</head>
<body>
    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')

    <script defer src="{{ asset('assets/js/plugins/jquery.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/odometer.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/jquery-appear.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/gsap.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/split-text.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/scroll-trigger.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/smooth-scroll.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/metismenu.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/popup.js') }}"></script>
    <script defer src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/swiper.js') }}"></script>
    <script defer src="{{ asset('assets/js/plugins/contact.form.js') }}"></script>
    <script defer src="{{ asset('assets/js/vendor/waw.js') }}"></script>
    <script defer src="{{ asset('assets/js/main.js') }}"></script>
    <script defer src="{{ asset('theme/theme-lazy.js') }}"></script>
    @stack('scripts')
</body>
</html>

