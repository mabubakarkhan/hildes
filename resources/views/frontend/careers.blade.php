@extends('frontend.layouts.app')

@section('content')
    <div class="careers-page-view">
        @include('frontend.partials.sections.page-hero', [
            'pre' => 'Join Our Team',
            'bgTitle' => 'Careers',
            'title' => $careersPage->title ?? 'Careers at HilDes',
        ])

        <section class="rts-section-gapBottom hildes-careers-jobs-section hildes-careers-jobs-section--rowcards">
            <div class="container">
                <div class="hildes-careers-jobs-head">
                    <span class="eyebrow"><span class="eyebrow-dot" aria-hidden="true"></span> Open positions</span>
                    <h2 class="title">Current opportunities</h2>
                    <p class="disc">Explore active roles below. Apply before the listed deadline.</p>
                </div>

                <div class="hildes-careers-jobs-stack">
                    @forelse($openJobs as $job)
                        @php
                            $iconClass = filled($job->icon_class) ? $job->icon_class : 'fa-regular fa-briefcase';
                            $subtitle = trim(implode(' ', array_filter([$job->department, $job->employment_type])));
                            $plainDesc = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $job->description)));
                            if (preg_match('/(Working hours\s*:[^.]+\.?)/iu', $plainDesc, $whMatch)) {
                                $workingHoursLine = $whMatch[1];
                                if (! str_ends_with($workingHoursLine, '.')) {
                                    $workingHoursLine .= '.';
                                }
                            } else {
                                $workingHoursLine = 'Working hours: 10:00 AM – 4:00 PM (6 hours per day), Monday to Friday.';
                            }
                            $snippetSource = trim(preg_replace('/Working hours\s*:[^.]+\.?\s*/iu', '', $plainDesc));
                            $secondLine = ($job->deadline ? 'Apply by: '.$job->deadline->format('j M Y').'. ' : '');
                            $secondLine .= \Illuminate\Support\Str::limit($snippetSource !== '' ? $snippetSource : 'Learn more about this role and how to apply.', 240);
                        @endphp
                        <article class="hildes-careers-job-rowcard" id="job-{{ $job->slug }}">
                            <div class="hildes-careers-job-rowcard__row hildes-careers-job-rowcard__row--head">
                                <div class="hildes-careers-job-rowcard__iconbox" aria-hidden="true">
                                    <i class="{{ $iconClass }}"></i>
                                </div>
                                <div class="hildes-careers-job-rowcard__headtext">
                                    <h3 class="hildes-careers-job-rowcard__title">{{ $job->title }}</h3>
                                    @if(filled($subtitle))
                                        <p class="hildes-careers-job-rowcard__subtitle">{{ $subtitle }}</p>
                                    @endif
                                </div>
                                <div class="hildes-careers-job-rowcard__headactions">
                                    <a href="{{ route('careers.job.show', ['job' => $job->slug]) }}#apply" class="rts-btn btn-primary hildes-careers-job-rowcard__apply">Apply now <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                                </div>
                            </div>

                            <div class="hildes-careers-job-rowcard__divider" role="presentation"></div>

                            <div class="hildes-careers-job-rowcard__row hildes-careers-job-rowcard__row--facts">
                                <div class="hildes-careers-job-rowcard__fact">
                                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                    <span class="hildes-careers-job-rowcard__fact-value">{{ filled($job->location) ? $job->location : '—' }}</span>
                                    <span class="hildes-careers-job-rowcard__fact-label">Location</span>
                                </div>
                                <div class="hildes-careers-job-rowcard__fact">
                                    <i class="fa-regular fa-file-lines" aria-hidden="true"></i>
                                    <span class="hildes-careers-job-rowcard__fact-value">{{ filled($job->work_mode) ? $job->work_mode : '—' }}</span>
                                    <span class="hildes-careers-job-rowcard__fact-label">Work mode</span>
                                </div>
                                <div class="hildes-careers-job-rowcard__fact">
                                    <i class="fa-solid fa-user-graduate" aria-hidden="true"></i>
                                    <span class="hildes-careers-job-rowcard__fact-value">{{ filled($job->experience_level) ? $job->experience_level : '—' }}</span>
                                    <span class="hildes-careers-job-rowcard__fact-label">Experience level</span>
                                </div>
                                <div class="hildes-careers-job-rowcard__fact">
                                    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                    <span class="hildes-careers-job-rowcard__fact-value">{{ $job->deadline ? 'Apply by '.$job->deadline->format('j M Y') : '—' }}</span>
                                    <span class="hildes-careers-job-rowcard__fact-label">Application deadline</span>
                                </div>
                                <div class="hildes-careers-job-rowcard__fact">
                                    <span class="hildes-careers-job-rowcard__fact-dollar" aria-hidden="true"><i class="fa-solid fa-dollar-sign"></i></span>
                                    <span class="hildes-careers-job-rowcard__fact-value">{{ filled($job->salary_range) ? $job->salary_range : '—' }}</span>
                                    <span class="hildes-careers-job-rowcard__fact-label">Compensation</span>
                                </div>
                            </div>

                            <div class="hildes-careers-job-rowcard__divider" role="presentation"></div>

                            <div class="hildes-careers-job-rowcard__row hildes-careers-job-rowcard__row--foot">
                                <div class="hildes-careers-job-rowcard__footcopy">
                                    <p class="hildes-careers-job-rowcard__hours">{{ $workingHoursLine }}</p>
                                    <p class="hildes-careers-job-rowcard__excerpt">{{ $secondLine }}</p>
                                </div>
                                <a href="{{ route('careers.job.show', ['job' => $job->slug]) }}" class="hildes-careers-job-rowcard__details">View details <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
                            </div>
                        </article>
                    @empty
                        <div class="hildes-careers-job-rowcard hildes-careers-job-rowcard--empty">
                            <p class="mb-0">There are no open positions right now. Please check again soon or reach out through <a href="{{ route('contact') }}">Contact Us</a>.</p>
                        </div>
                    @endforelse
                </div>

                @if($openJobs->isNotEmpty())
                    <div class="hildes-careers-resume-cta" role="complementary">
                        <div class="hildes-careers-resume-cta__icon" aria-hidden="true">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="hildes-careers-resume-cta__copy">
                            <strong class="hildes-careers-resume-cta__head">Don’t see the right role?</strong>
                            <p class="hildes-careers-resume-cta__text">We’re always looking for talented people. Send us your resume and we’ll keep you in mind for future opportunities.</p>
                        </div>
                        <a href="{{ route('contact') }}" class="rts-btn btn-border hildes-careers-resume-cta__btn">Send your resume <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                @endif
            </div>
        </section>

        @if(filled($careersCmsDetail ?? null))
            <section class="rts-section-gapBottom hildes-careers-cms-intro">
                <div class="container">
                    <div class="hildes-services-cms-card hildes-careers-cms-card">
                        {!! $careersCmsDetail !!}
                    </div>
                </div>
            </section>
        @endif

        @if(($careersCmsFaqs ?? collect())->isNotEmpty())
            <section class="rts-section-gapBottom hildes-services-faq-block hildes-careers-faq-block">
                <div class="container">
                    <div class="service-section-card service-section-card--b service-faq-section">
                        <h3 class="title">Popular Questions</h3>
                        <div class="accordion faq-wrapper-inner-page mt--20" id="accordionCareersPageFaq">
                            @foreach($careersCmsFaqs as $index => $faq)
                                @php($collapseId = 'careersPageFaqCollapse' . $index)
                                @php($headingId = 'careersPageFaqHeading' . $index)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="{{ $headingId }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                            {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ data_get($faq, 'title') }}
                                        </button>
                                    </h2>
                                    <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionCareersPageFaq">
                                        <div class="accordion-body">{!! data_get($faq, 'detail') !!}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <div class="careers-page-end-spacer" aria-hidden="true"></div>
    </div>
@endsection
