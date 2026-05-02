@extends('frontend.layouts.app')

@section('content')
    <div class="rts-breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-left">
                        <span class="pre">FAQs</span>
                        <span class="bg-title">FAQs</span>
                        <h1 class="title rts-text-anime-style-1">
                            Frequently Asked <br>
                            Questions.
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(filled($faqBannerImageUrl ?? null))
        <div class="about-invena-large-image">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="large-image-bottm-breadcrumb">
                            <img src="{{ $faqBannerImageUrl }}" alt="{{ $faqBannerImageAlt }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(filled($faqDetailHtml ?? null))
        <section class="faqs-page-detail">
            <div class="container">
                <div class="faqs-page-detail-card">
                    {!! $faqDetailHtml !!}
                </div>
            </div>
        </section>
    @endif

    @php($hasNormalFaqs = ($faqNormalItems ?? collect())->isNotEmpty())
    @if(($faqGroups ?? collect())->isNotEmpty())
        <section class="rts-section-gapBottom faqs-group-tabs-wrap {{ $hasNormalFaqs ? '' : 'faqs-page-last-section' }}">
            <div class="container">
                <div class="title-style-two center mb--30">
                    <span class="bg-content">Groups</span>
                    <span class="pre">FAQ Categories</span>
                    <h2 class="title rts-text-anime-style-1">Browse by Topic</h2>
                </div>
                <div class="faqs-group-tabs" id="faqs-group-tabs">
                    <div class="faqs-group-tab-buttons" role="tablist" aria-label="FAQ category tabs">
                        @foreach($faqGroups as $groupIndex => $group)
                            <button type="button" class="faqs-group-tab-btn {{ $groupIndex === 0 ? 'is-active' : '' }}" data-faq-group-tab="{{ $groupIndex }}" role="tab" aria-selected="{{ $groupIndex === 0 ? 'true' : 'false' }}">
                                {{ data_get($group, 'category') }}
                            </button>
                        @endforeach
                    </div>
                    <div class="faqs-group-panels">
                        @foreach($faqGroups as $groupIndex => $group)
                            <div class="faqs-group-panel {{ $groupIndex === 0 ? 'is-active' : '' }}" data-faq-group-panel="{{ $groupIndex }}" role="tabpanel">
                                <div class="service-section-card service-section-card--b service-faq-section">
                                    <h3 class="title">{{ data_get($group, 'category') }}</h3>
                                    <div class="accordion faq-wrapper-inner-page mt--20" id="accordionFaqGroup{{ $groupIndex }}">
                                        @foreach(data_get($group, 'items', collect()) as $itemIndex => $faq)
                                            @php($collapseId = 'faqGroupCollapse' . $groupIndex . '_' . $itemIndex)
                                            @php($headingId = 'faqGroupHeading' . $groupIndex . '_' . $itemIndex)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="{{ $headingId }}">
                                                    <button class="accordion-button {{ $itemIndex > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $itemIndex === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                                        {{ str_pad((string) ($itemIndex + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                                    </button>
                                                </h2>
                                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $itemIndex === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionFaqGroup{{ $groupIndex }}">
                                                    <div class="accordion-body">{!! data_get($faq, 'detail') !!}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($hasNormalFaqs)
        <section class="rts-section-gapBottom hildes-services-faq-block faqs-page-last-section">
            <div class="container">
                <div class="service-section-card service-section-card--b service-faq-section">
                    <h3 class="title">Popular Questions</h3>
                    <div class="accordion faq-wrapper-inner-page mt--20" id="accordionFaqsPage">
                        @foreach($faqNormalItems as $index => $faq)
                            @php($collapseId = 'faqsPageCollapse' . $index)
                            @php($headingId = 'faqsPageHeading' . $index)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                    </button>
                                </h2>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionFaqsPage">
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

@push('scripts')
<script>
(() => {
    const root = document.getElementById('faqs-group-tabs');
    if (!root) return;

    const tabs = Array.from(root.querySelectorAll('[data-faq-group-tab]'));
    const panels = Array.from(root.querySelectorAll('[data-faq-group-panel]'));

    const isMobile = () => window.matchMedia('(max-width: 767px)').matches;

    const activate = (id, options = {}) => {
        tabs.forEach((tab) => {
            const active = tab.getAttribute('data-faq-group-tab') === id;
            tab.classList.toggle('is-active', active);
            tab.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        panels.forEach((panel) => {
            const active = panel.getAttribute('data-faq-group-panel') === id;
            panel.classList.toggle('is-active', active);
            if (active && options.scroll && isMobile()) {
                // small timeout to allow classes to apply before scrolling
                setTimeout(() => {
                    // add 70px offset to account for any fixed headers and spacing
                    const offset = 120;
                    const y = panel.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }, 60);
            }
        });
    };

    // If on mobile and no tab is active, activate the first tab
    const anyActive = tabs.some(t => t.classList.contains('is-active'));
    if (isMobile() && !anyActive && tabs.length) {
        const id = tabs[0].getAttribute('data-faq-group-tab') || '0';
        activate(id);
    }

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const id = tab.getAttribute('data-faq-group-tab') || '0';
            activate(id, { scroll: true });
        });
    });
})();
</script>
@endpush
