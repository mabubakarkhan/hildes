@extends('frontend.layouts.app')

@php
    $faqs = collect($service->faqs_json ?? [])->filter(fn ($item) => filled(data_get($item, 'title')) && filled(data_get($item, 'detail')))->values();
    $toLines = function (?string $value) {
        $text = (string) $value;
        if ($text === '') {
            return collect();
        }

        // Normalize rich-text content from CKEditor (paragraphs/lists) into clean lines.
        $normalized = preg_replace('/<\s*br\s*\/?\s*>/i', "\n", $text);
        $normalized = preg_replace('/<\/\s*(p|div|li|h[1-6])\s*>/i', "\n", $normalized);
        $normalized = strip_tags($normalized);
        $normalized = html_entity_decode($normalized, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return collect(preg_split('/\r\n|\r|\n/', $normalized))
            ->map(fn ($line) => trim(preg_replace('/\s+/', ' ', $line)))
            ->filter()
            ->values();
    };

    $deliverables = $toLines($service->deliverables_text);
    $processLines = $toLines($service->process_text);
    $globalLines = $toLines($service->global_focus_text);
    $processSteps = collect();
    $currentStep = null;
    foreach ($processLines as $line) {
        if (preg_match('/^(\d+)\.\s*(.+)$/', $line, $matches)) {
            if ($currentStep) {
                $processSteps->push($currentStep);
            }
            $currentStep = [
                'number' => (int) $matches[1],
                'title' => trim($matches[2]),
                'detail' => [],
            ];
            continue;
        }

        if (! $currentStep) {
            $currentStep = [
                'number' => $processSteps->count() + 1,
                'title' => $line,
                'detail' => [],
            ];
            continue;
        }

        $currentStep['detail'][] = $line;
    }
    if ($currentStep) {
        $processSteps->push($currentStep);
    }
    $processIcons = [
        'fa-solid fa-magnifying-glass',
        'fa-solid fa-compass-drafting',
        'fa-solid fa-laptop-code',
        'fa-solid fa-rocket',
        'fa-solid fa-cloud-arrow-up',
    ];
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
                                        <span class="bg-title">{{ $service->name }}</span>
                                        <h1 class="title rts-text-anime-style-1 service-hero-title-black">{{ $service->hero_headline ?: $service->name }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rts-service-details-area-main-bottom service-page-detail">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-8 col-lg-7">
                    <div class="service-details-left-area">
                        @if(filled($service->hero_content))
                            <div class="service-section-card service-section-card--a">
                                <div class="service-hero-intro">
                                    <span class="eyebrow">Overview</span>
                                    <div class="disc">{!! $service->hero_content !!}</div>
                                </div>
                            </div>
                        @endif

                        <div class="service-section-card service-section-card--b">
                            @if($service->hero_image)
                                <div class="thumbnail">
                                    <img src="{{ $service->hero_image_url }}" alt="{{ $service->hero_image_alt ?: $service->name }}">
                                </div>
                            @endif

                            <h3 class="title">{{ $service->body_heading ?: $service->name }}</h3>
                            @if(filled($service->body_content))
                                <div class="disc">{!! $service->body_content !!}</div>
                            @endif
                        </div>

                        @if($deliverables->isNotEmpty())
                            <div class="service-section-card service-section-card--c">
                                <h3 class="title">What We Deliver</h3>
                                <div class="service-short-main-wrapper">
                                    @foreach($deliverables as $item)
                                        <div class="single-short-service">
                                            <div class="inner-content">
                                                <h5 class="title-sm">{{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}. {{ $item }}</h5>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($processSteps->isNotEmpty())
                            <div class="service-section-card service-section-card--d">
                                <h3 class="title">Development Process</h3>
                                <div class="service-process-flow">
                                    <div class="service-process-track">
                                        @foreach($processSteps as $step)
                                            <div class="service-process-step">
                                                <div class="service-step-number">{{ str_pad((string) $step['number'], 2, '0', STR_PAD_LEFT) }}</div>
                                                <div class="service-step-card">
                                                    <div class="service-step-content">
                                                        <div class="service-step-icon-wrap">
                                                            <i class="{{ $processIcons[($loop->index) % count($processIcons)] }}" aria-hidden="true"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="service-step-title">{{ $step['title'] }}</h5>
                                                            @if(!empty($step['detail']))
                                                                <p class="service-step-detail">{{ implode(' ', $step['detail']) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($globalLines->isNotEmpty())
                            <div class="service-section-card service-section-card--c">
                                <h3 class="title">Global Focus</h3>
                                <div class="disc">
                                    @foreach($globalLines as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                </div>
                                @if($service->body_image)
                                    <div class="service-process-image-wrap mt-4">
                                        <img src="{{ $service->body_image_url }}" alt="{{ $service->body_image_alt ?: $service->name }}">
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($faqs->isNotEmpty())
                            <div class="service-section-card service-section-card--b service-faq-section">
                                <h3 class="title">Popular Question</h3>
                                <div class="accordion faq-wrapper-inner-page mt--20" id="accordionServiceFaq">
                                    @foreach($faqs as $index => $faq)
                                        @php($collapseId = 'faqCollapse' . $index)
                                        @php($headingId = 'faqHeading' . $index)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="{{ $headingId }}">
                                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                                </button>
                                            </h2>
                                            <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionServiceFaq">
                                                <div class="accordion-body">{!! data_get($faq, 'detail') !!}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="service-section-card service-section-card--b case-study-contact-inline case-study-contact-inline-bottom">
                            <h3 class="title">Discuss Your Project</h3>
                            <p class="case-study-contact-subtitle">Share your requirements and our team will get back to you.</p>
                            <form class="case-study-contact-form" method="POST" action="#">
                                <div class="form-group">
                                    <label for="service_contact_name_bottom">Name</label>
                                    <input id="service_contact_name_bottom" name="name" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="service_contact_phone_bottom">Phone</label>
                                    <input id="service_contact_phone_bottom" name="phone" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="service_contact_email_bottom">Email</label>
                                    <input id="service_contact_email_bottom" name="email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="service_contact_comment_bottom">Comment</label>
                                    <textarea id="service_contact_comment_bottom" name="comment" rows="4"></textarea>
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
                            <form id="service-contact-form-anchor" class="case-study-contact-form" method="POST" action="#">
                                <div class="form-group">
                                    <label for="service_contact_name_top">Name</label>
                                    <input id="service_contact_name_top" name="name" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label for="service_contact_phone_top">Phone</label>
                                    <input id="service_contact_phone_top" name="phone" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="service_contact_email_top">Email</label>
                                    <input id="service_contact_email_top" name="email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="service_contact_comment_top">Comment</label>
                                    <textarea id="service_contact_comment_top" name="comment" rows="4"></textarea>
                                </div>
                                <button type="submit" class="rts-btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </aside>

                    @if(($sidebarRemainingServices ?? collect())->isNotEmpty())
                        <div class="service-section-card service-section-card--b case-study-contact-inline case-study-widget-card mt-4">
                            <h4 class="case-study-contact-title">Remaining Services</h4>
                            <ul class="case-study-widget-list">
                                @foreach($sidebarRemainingServices as $item)
                                    <li>
                                        <a href="{{ route('service.slug', $item->slug) }}">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(($sidebarCaseStudies ?? collect())->isNotEmpty())
                        <div class="service-section-card service-section-card--b case-study-contact-inline case-study-widget-card mt-4">
                            <h4 class="case-study-contact-title">All Case Studies</h4>
                            <ul class="case-study-widget-list">
                                @foreach($sidebarCaseStudies as $item)
                                    <li>
                                        <a href="{{ route('case-studies.show', $item->slug) }}">{{ $item->title }}</a>
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
