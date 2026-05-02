@extends('frontend.layouts.app')

@php
    $sections = collect($caseStudy->sections_json ?? []);
    $sectionLabels = [
        'overview' => 'Project Overview',
        'challenge' => 'The Challenge',
        'approach' => 'Our Approach',
        'infrastructure' => 'Infrastructure Transformation',
        'stabilization' => 'Development & Codebase Stabilization',
        'devops' => 'DevOps & CI/CD Implementation',
        'quality' => 'Code Quality & Testing',
        'process' => 'Process & SDLC Implementation',
        'security' => 'Security & Reliability Enhancements',
        'performance' => 'Performance Optimization',
        'modernization' => 'Modernization & Future Scalability',
        'results' => 'Final Results',
        'outcome' => 'Client Outcome',
    ];
    $sectionIcons = [
        'overview' => '🏢',
        'challenge' => '🚨',
        'approach' => '🧠',
        'infrastructure' => '⚙️',
        'stabilization' => '💻',
        'devops' => '🔁',
        'quality' => '🧪',
        'process' => '📊',
        'security' => '🔐',
        'performance' => '⚡',
        'modernization' => '🧱',
        'results' => '📈',
        'outcome' => '💬',
    ];
    $orderedSections = collect($sectionLabels)
        ->map(function ($label, $key) use ($sections, $sectionIcons) {
            return [
                'key' => $key,
                'label' => $label,
                'icon' => data_get($sectionIcons, $key, '📄'),
                'content' => data_get($sections, $key),
            ];
        })
        ->filter(fn ($item) => filled($item['content']))
        ->values();
@endphp

@section('content')
    <div class="breadcrumb-service-detals-one">
        <div class="container-1754">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-inner-service-details-1 bg_image">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="title-area-left">
                                        <span class="bg-title">Case Study</span>
                                        <h1 class="title rts-text-anime-style-1 service-hero-title-black">{{ $caseStudy->title }}</h1>
                                        @if(filled($caseStudy->tagline))
                                            <p class="disc mt-2">{{ $caseStudy->tagline }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rts-service-details-area-main-bottom">
        <div class="container">
            <div class="row justify-content-center case-study-content-row">
                <div class="col-xl-8 col-lg-7">
                    <div class="service-details-left-area">
                        @if(filled($caseStudy->short_description))
                            <div class="service-section-card service-section-card--a">
                                <div class="service-hero-intro">
                                    <span class="eyebrow">Summary</span>
                                    <div class="disc">
                                        <p>{{ $caseStudy->short_description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($caseStudy->featured_image)
                            <div class="service-section-card service-section-card--b">
                                <div class="thumbnail">
                                    <img src="{{ $caseStudy->featured_image_url }}" alt="{{ $caseStudy->featured_image_alt ?: $caseStudy->title }}">
                                </div>
                            </div>
                        @endif

                        @if($orderedSections->isNotEmpty())
                            @foreach($orderedSections as $section)
                                <div class="service-section-card case-study-section-card {{ $loop->last ? 'case-study-last-section' : '' }} {{ $loop->iteration % 2 === 0 ? 'service-section-card--c' : 'service-section-card--d' }}">
                                    <h3 class="title"><span class="case-study-section-icon">{{ $section['icon'] }}</span> {{ $section['label'] }}</h3>
                                    <div class="disc case-study-section-content">{!! $section['content'] !!}</div>
                                </div>
                            @endforeach
                        @elseif(filled($caseStudy->detail_content))
                            <div class="service-section-card service-section-card--c case-study-last-section">
                                <h3 class="title">Case Study Details</h3>
                                <div class="disc case-study-section-content">{!! $caseStudy->detail_content !!}</div>
                            </div>
                        @else
                            <div class="service-section-card service-section-card--c case-study-last-section">
                                <h3 class="title">Case Study Details</h3>
                                <div class="disc"><p>Case study details will be published here soon.</p></div>
                            </div>
                        @endif

                        <div class="service-section-card service-section-card--b case-study-contact-inline case-study-contact-inline-bottom">
                            <h3 class="title">Discuss Your Project</h3>
                            <p class="case-study-contact-subtitle">Share your requirements and our team will get back to you.</p>
                            <form class="case-study-contact-form" method="POST" action="#">
                                <div class="form-group">
                                    <label for="case_contact_name_bottom">Name</label>
                                    <input id="case_contact_name_bottom" name="name" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="case_contact_phone_bottom">Phone</label>
                                    <input id="case_contact_phone_bottom" name="phone" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="case_contact_email_bottom">Email</label>
                                    <input id="case_contact_email_bottom" name="email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="case_contact_comment_bottom">Comment</label>
                                    <textarea id="case_contact_comment_bottom" name="comment" rows="4"></textarea>
                                </div>
                                <button type="submit" class="rts-btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <aside class="case-study-contact-wrap">
                        <div class="service-section-card service-section-card--b case-study-contact-inline">
                            <h3 class="title">Discuss Your Project</h3>
                            <p class="case-study-contact-subtitle">Share your requirements and our team will get back to you.</p>
                            <form id="case-study-contact-form-anchor" class="case-study-contact-form" method="POST" action="#">
                                <div class="form-group">
                                    <label for="case_contact_name_top">Name</label>
                                    <input id="case_contact_name_top" name="name" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="case_contact_phone_top">Phone</label>
                                    <input id="case_contact_phone_top" name="phone" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="case_contact_email_top">Email</label>
                                    <input id="case_contact_email_top" name="email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="case_contact_comment_top">Comment</label>
                                    <textarea id="case_contact_comment_top" name="comment" rows="4"></textarea>
                                </div>
                                <button type="submit" class="rts-btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </aside>

                    @if(collect($sidebarCaseStudies ?? [])->isNotEmpty())
                        <div class="service-section-card service-section-card--b case-study-contact-inline case-study-widget-card mt-4">
                            <h4 class="case-study-contact-title">Other Case Studies</h4>
                            <ul class="case-study-widget-list">
                                @foreach($sidebarCaseStudies as $item)
                                    <li>
                                        <a href="{{ route('case-studies.show', $item->slug) }}">{{ $item->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(collect($sidebarServices ?? [])->isNotEmpty())
                        <div class="service-section-card service-section-card--b case-study-contact-inline case-study-widget-card mt-4">
                            <h4 class="case-study-contact-title">Services</h4>
                            <ul class="case-study-widget-list">
                                @foreach($sidebarServices as $item)
                                    <li>
                                        <a href="{{ route('service.slug', $item->slug) }}">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

